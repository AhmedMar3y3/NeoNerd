<?php
namespace App\Services;

use App\Enums\AcademicLevel;
use App\Enums\ScientificBranch;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\SecondaryType;
use App\Models\College;
use App\Models\Grade;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AcademicProfileService
{
    public function completeAcademicProfile(User $user, array $data): bool
    {
        DB::beginTransaction();

        try {
            if ($data['academic_level'] === AcademicLevel::UNIVERSITY->value) {
                $this->validateUniversityData($data);
            } else {
                $this->validateSecondaryData($data);
            }

            $user->update([
                'first_name'              => $data['first_name'],
                'last_name'               => $data['last_name'],
                'gender'                  => $data['gender'],
                'academic_level'          => $data['academic_level'],
                'is_academic_details_set' => true,
            ]);

            if ($user->isUniversityStudent()) {
                $user->update([
                    'university_id' => $data['university_id'],
                    'college_id'    => $data['college_id'],
                    'grade_id'      => $data['grade_id'],
                ]);
            } else {
                $user->update([
                    'secondary_type'    => $data['secondary_type'],
                    'secondary_grade'   => $data['secondary_grade'],
                    'secondary_section' => $data['secondary_section'] ?? null,
                    'scientific_branch' => $data['scientific_branch'] ?? null,
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateAcademicProfile(User $user, array $data): bool
    {
        DB::beginTransaction();
        try {
            if (! $user->profile_completed()) {
                throw ValidationException::withMessages([
                    'profile' => 'يجب إكمال الملف الشخصي قبل تحديث المعلومات الأكاديمية.',
                ]);
            }

            if (isset($data['academic_level']) && $data['academic_level'] !== $user->academic_level->value) {
                $this->handleAcademicLevelChange($user, $data);
            } else {
                if ($user->isUniversityStudent()) {
                    $this->updateUniversityProfile($user, $data);
                } else {
                    $this->updateSecondaryProfile($user, $data);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function handleAcademicLevelChange(User $user, array $data): void
    {
        if ($data['academic_level'] === AcademicLevel::UNIVERSITY->value) {
            $this->validateUniversityData($data);
        } else {
            $this->validateSecondaryData($data);
        }

        $user->update([
            'university_id'     => null,
            'college_id'        => null,
            'grade_id'          => null,
            'secondary_type'    => null,
            'secondary_grade'   => null,
            'secondary_section' => null,
            'scientific_branch' => null,
        ]);

        $user->update([
            'academic_level' => $data['academic_level'],
        ]);

        if ($data['academic_level'] === AcademicLevel::UNIVERSITY->value) {
            $user->update([
                'university_id' => $data['university_id'],
                'college_id'    => $data['college_id'],
                'grade_id'      => $data['grade_id'],
            ]);
        } else {
            $user->update([
                'secondary_type'    => $data['secondary_type'],
                'secondary_grade'   => $data['secondary_grade'],
                'secondary_section' => $data['secondary_section'] ?? null,
                'scientific_branch' => $data['scientific_branch'] ?? null,
            ]);
        }
    }

    private function updateUniversityProfile(User $user, array $data): void
    {
        $updates = [];

        if (isset($data['university_id'])) {
            $updates['university_id'] = $data['university_id'];
            $updates['college_id']    = null;
            $updates['grade_id']      = null;
        }

        if (isset($data['college_id'])) {
            $college = College::find($data['college_id']);
            if (! $college || $college->university_id != ($data['university_id'] ?? $user->university_id)) {
                throw ValidationException::withMessages([
                    'college_id' => 'الكلية المختارة لا تتبع الجامعة المحددة.',
                ]);
            }
            $updates['college_id'] = $data['college_id'];
            $updates['grade_id']   = null;
        }

        if (isset($data['grade_id'])) {
            $grade = Grade::find($data['grade_id']);
            if (! $grade || $grade->college_id != ($data['college_id'] ?? $user->college_id)) {
                throw ValidationException::withMessages([
                    'grade_id' => 'الصف المختار لا يتبع الكلية المحددة.',
                ]);
            }
            $updates['grade_id'] = $data['grade_id'];
        }

        if (! empty($updates)) {
            $user->update($updates);
        }
    }

    private function updateSecondaryProfile(User $user, array $data): void
    {
        $updates = [];

        if (isset($data['secondary_type'])) {
            $updates['secondary_type'] = $data['secondary_type'];
        }

        if (isset($data['secondary_grade'])) {
            $updates['secondary_grade'] = $data['secondary_grade'];

            if ($data['secondary_grade'] === SecondaryGrade::FIRST->value) {
                $updates['secondary_section'] = null;
                $updates['scientific_branch'] = null;
            }
        }

        if (isset($data['secondary_section'])) {
            $grade = $data['secondary_grade'] ?? $user->secondary_grade;

            if ($grade === SecondaryGrade::FIRST) {
                throw ValidationException::withMessages([
                    'secondary_section' => 'القسم غير متاح للصف الأول الثانوي.',
                ]);
            }

            $updates['secondary_section'] = $data['secondary_section'];

            if ($data['secondary_section'] === SecondarySection::LITERAL->value) {
                $updates['scientific_branch'] = null;
            }
        }

        if (isset($data['scientific_branch'])) {
            $grade   = $data['secondary_grade'] ?? $user->secondary_grade;
            $section = $data['secondary_section'] ?? $user->secondary_section;

            if ($grade !== SecondaryGrade::THIRD || $section !== SecondarySection::SCIENTIFIC) {
                throw ValidationException::withMessages([
                    'scientific_branch' => 'فرع العلمي متاح فقط للصف الثالث القسم العلمي.',
                ]);
            }

            $updates['scientific_branch'] = $data['scientific_branch'];
        }

        if (! empty($updates)) {
            $user->update($updates);
        }
    }

    private function validateUniversityData(array $data): void
    {
        if (! isset($data['university_id']) || ! isset($data['college_id']) || ! isset($data['grade_id'])) {
            throw ValidationException::withMessages([
                'university_id' => 'يجب اختيار الجامعة والكلية والصف للطلاب الجامعيين.',
                'college_id'    => 'يجب اختيار الجامعة والكلية والصف للطلاب الجامعيين.',
                'grade_id'      => 'يجب اختيار الجامعة والكلية والصف للطلاب الجامعيين.',
            ]);
        }

        $college = College::find($data['college_id']);
        if (! $college || $college->university_id != $data['university_id']) {
            throw ValidationException::withMessages([
                'college_id' => 'الكلية المختارة لا تتبع الجامعة المحددة.',
            ]);
        }

        $grade = Grade::find($data['grade_id']);
        if (! $grade || $grade->college_id != $data['college_id']) {
            throw ValidationException::withMessages([
                'grade_id' => 'الصف المختار لا يتبع الكلية المحددة.',
            ]);
        }
    }

    private function validateSecondaryData(array $data): void
    {
        if (! isset($data['secondary_type']) || ! isset($data['secondary_grade'])) {
            throw ValidationException::withMessages([
                'secondary_type'  => 'يجب اختيار نوع التعليم والصف للطلاب الثانويين.',
                'secondary_grade' => 'يجب اختيار نوع التعليم والصف للطلاب الثانويين.',
            ]);
        }

        $grade = SecondaryGrade::from($data['secondary_grade']);

        if (in_array($grade, [SecondaryGrade::SECOND, SecondaryGrade::THIRD])) {
            if (! isset($data['secondary_section'])) {
                throw ValidationException::withMessages([
                    'secondary_section' => 'القسم مطلوب للصف الثاني والثالث الثانوي.',
                ]);
            }
        }

        if (
            $grade === SecondaryGrade::THIRD &&
            isset($data['secondary_section']) &&
            $data['secondary_section'] === SecondarySection::SCIENTIFIC->value
        ) {
            if (! isset($data['scientific_branch'])) {
                throw ValidationException::withMessages([
                    'scientific_branch' => 'فرع العلمي مطلوب للصف الثالث القسم العلمي.',
                ]);
            }
        }
    }

    public function getUniversities()
    {
        return University::orderBy('name')->get(['id', 'name']);
    }

    public function getCollegesByUniversity(int $universityId)
    {
        return College::where('university_id', $universityId)->orderBy('name')->get(['id', 'name']);
    }

    public function getGradesByCollege(int $collegeId)
    {
        return Grade::where('college_id', $collegeId)->orderBy('level')->get(['id', 'name']);
    }

    public function getSecondaryTypes()
    {
        return collect(SecondaryType::cases())->map(function ($type) {
            return [
                'value' => $type->value,
                'label' => $this->getTypeLabel($type),
            ];
        });
    }

    public function getSecondaryGrades()
    {
        return collect(SecondaryGrade::cases())->map(function ($grade) {
            return [
                'value' => $grade->value,
                'label' => $this->getGradeLabel($grade),
            ];
        });
    }

    public function getSecondarySections()
    {
        return collect(SecondarySection::cases())->map(function ($section) {
            return [
                'value' => $section->value,
                'label' => $this->getSectionLabel($section),
            ];
        });
    }

    public function getScientificBranches()
    {
        return collect(ScientificBranch::cases())->map(function ($branch) {
            return [
                'value' => $branch->value,
                'label' => $this->getBranchLabel($branch),
            ];
        });
    }

    private function getGradeLabel(SecondaryGrade $grade): string
    {
        return match ($grade) {
            SecondaryGrade::FIRST => 'الصف الأول الثانوي',
            SecondaryGrade::SECOND => 'الصف الثاني الثانوي',
            SecondaryGrade::THIRD => 'الصف الثالث الثانوي',
        };
    }

    private function getTypeLabel(SecondaryType $type): string
    {
        return match ($type) {
            SecondaryType::ARABIC => 'عربي',
            SecondaryType::LANGUAGE => 'لغات',
        };
    }

    private function getSectionLabel(SecondarySection $section): string
    {
        return match ($section) {
            SecondarySection::LITERAL => 'أدبي',
            SecondarySection::SCIENTIFIC => 'علمي',
        };
    }

    private function getBranchLabel(ScientificBranch $branch): string
    {
        return match ($branch) {
            ScientificBranch::SCIENCE => 'علوم',
            ScientificBranch::MATH => 'رياضيات',
        };
    }
}
