<?php

namespace App\Services;

use App\Models\User;
use App\Models\Grade;
use App\Models\College;
use App\Models\University;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;
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
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'academic_level' => $data['academic_level'],
                // 'image' => $data['image'] ?? null,
                'is_academic_details_set' => true,
            ]);

            if ($user->isUniversityStudent()) {
                $user->update([
                    'university_id' => $data['university_id'],
                    'college_id' => $data['college_id'],
                    'grade_id' => $data['grade_id'],
                ]);
            } else {
                $user->update([
                    'secondary_type' => $data['secondary_type'],
                    'secondary_grade' => $data['secondary_grade'],
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

    private function validateUniversityData(array $data): void
    {
        if (!isset($data['university_id']) || !isset($data['college_id']) || !isset($data['grade_id'])) {
            throw ValidationException::withMessages([
                'university_id' => 'University, college, and grade are required for university students.',
                'college_id' => 'University, college, and grade are required for university students.',
                'grade_id' => 'University, college, and grade are required for university students.',
            ]);
        }

        $college = College::find($data['college_id']);
        if (!$college || $college->university_id != $data['university_id']) {
            throw ValidationException::withMessages([
                'college_id' => 'Selected college does not belong to the selected university.',
            ]);
        }

        $grade = Grade::find($data['grade_id']);
        if (!$grade || $grade->college_id != $data['college_id']) {
            throw ValidationException::withMessages([
                'grade_id' => 'Selected grade does not belong to the selected college.',
            ]);
        }
    }

    private function validateSecondaryData(array $data): void
    {
        if (!isset($data['secondary_type']) || !isset($data['secondary_grade'])) {
            throw ValidationException::withMessages([
                'secondary_type' => 'Secondary type and grade are required for secondary students.',
                'secondary_grade' => 'Secondary type and grade are required for secondary students.',
            ]);
        }

        $grade = SecondaryGrade::from($data['secondary_grade']);

        if (in_array($grade, [SecondaryGrade::SECOND, SecondaryGrade::THIRD])) {
            if (!isset($data['secondary_section'])) {
                throw ValidationException::withMessages([
                    'secondary_section' => 'Section is required for 2nd and 3rd grades.',
                ]);
            }
        }

        if (
            $grade === SecondaryGrade::THIRD &&
            isset($data['secondary_section']) &&
            $data['secondary_section'] === SecondarySection::SCIENTIFIC->value
        ) {
            if (!isset($data['scientific_branch'])) {
                throw ValidationException::withMessages([
                    'scientific_branch' => 'Scientific branch is required for 3rd grade scientific section.',
                ]);
            }
        }
    }

    /**
     * Get universities for selection
     */
    public function getUniversities()
    {
        return University::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Get colleges for a specific university
     */
    public function getCollegesByUniversity(int $universityId)
    {
        return College::where('university_id', $universityId)->orderBy('name')->get(['id', 'name']);
    }

    /**
     * Get grades for a specific college
     */
    public function getGradesByCollege(int $collegeId)
    {
        return Grade::where('college_id', $collegeId)->orderBy('level')->get(['id', 'name']);
    }

    /**
     * Get secondary types
     */
    public function getSecondaryTypes()
    {
        return collect(SecondaryType::cases())->map(function ($type) {
            return [
                'value' => $type->value,
                'label' => $this->getTypeLabel($type),
            ];
        });
    }

    /**
     * Get available secondary grades
     */
    public function getSecondaryGrades()
    {
        return collect(SecondaryGrade::cases())->map(function ($grade) {
            return [
                'value' => $grade->value,
                'label' => $this->getGradeLabel($grade),
            ];
        });
    }

    /**
     * Get available secondary sections
     */
    public function getSecondarySections()
    {
        return collect(SecondarySection::cases())->map(function ($section) {
            return [
                'value' => $section->value,
                'label' => $this->getSectionLabel($section),
            ];
        });
    }

    /**
     * Get available scientific branches
     */
    public function getScientificBranches()
    {
        return collect(ScientificBranch::cases())->map(function ($branch) {
            return [
                'value' => $branch->value,
                'label' => $this->getBranchLabel($branch),
            ];
        });
    }

    /**
     * Get grade label for display
     */
    private function getGradeLabel(SecondaryGrade $grade): string
    {
        return match ($grade) {
            SecondaryGrade::FIRST => 'الصف الأول الثانوي',
            SecondaryGrade::SECOND => 'الصف الثاني الثانوي',
            SecondaryGrade::THIRD => 'الصف الثالث الثانوي',
        };
    }

    /**
     * Get type label for display
     */
    private function getTypeLabel(SecondaryType $type): string
    {
        return match ($type) {
            SecondaryType::ARABIC => 'عربي',
            SecondaryType::LANGUAGE => 'لغات',
        };
    }

    /**
     * Get section label for display
     */
    private function getSectionLabel(SecondarySection $section): string
    {
        return match ($section) {
            SecondarySection::LITERAL => 'أدبي',
            SecondarySection::SCIENTIFIC => 'علمي',
        };
    }

    /**
     * Get branch label for display
     */
    private function getBranchLabel(ScientificBranch $branch): string
    {
        return match ($branch) {
            ScientificBranch::SCIENCE => 'علوم',
            ScientificBranch::MATH => 'رياضيات',
        };
    }
}
