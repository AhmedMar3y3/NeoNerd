<?php

namespace App\Services;

use App\Models\User;
use App\Models\University;
use App\Models\College;
use App\Models\Grade;
use App\Models\SecondaryType;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryType as SecondaryTypeEnum;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AcademicProfileService
{
    /**
     * Complete user's academic profile with all information in one request
     */
    public function completeAcademicProfile(User $user, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            // Validate the data based on academic level
            if ($user->isUniversityStudent()) {
                $this->validateUniversityData($data);
            } else {
                $this->validateSecondaryData($data);
            }

            // Update user with all profile information
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'academic_level' => $data['academic_level'],
                'image' => $data['image'] ?? null,
                'is_academic_details_set' => true,
            ]);

            // Update academic-specific fields based on level
            if ($user->isUniversityStudent()) {
                $user->update([
                    'university_id' => $data['university_id'],
                    'college_id' => $data['college_id'],
                    'grade_id' => $data['grade_id'],
                ]);
            } else {
                $user->update([
                    'secondary_type_id' => $data['secondary_type_id'],
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

    /**
     * Validate university profile data
     */
    private function validateUniversityData(array $data): void
    {
        if (!isset($data['university_id']) || !isset($data['college_id']) || !isset($data['grade_id'])) {
            throw ValidationException::withMessages([
                'university_id' => 'University, college, and grade are required for university students.',
                'college_id' => 'University, college, and grade are required for university students.',
                'grade_id' => 'University, college, and grade are required for university students.',
            ]);
        }

        // Validate that college belongs to university
        $college = College::find($data['college_id']);
        if (!$college || $college->university_id != $data['university_id']) {
            throw ValidationException::withMessages([
                'college_id' => 'Selected college does not belong to the selected university.',
            ]);
        }

        // Validate that grade belongs to college
        $grade = Grade::find($data['grade_id']);
        if (!$grade || $grade->college_id != $data['college_id']) {
            throw ValidationException::withMessages([
                'grade_id' => 'Selected grade does not belong to the selected college.',
            ]);
        }
    }

    /**
     * Validate secondary profile data
     */
    private function validateSecondaryData(array $data): void
    {
        if (!isset($data['secondary_type_id']) || !isset($data['secondary_grade'])) {
            throw ValidationException::withMessages([
                'secondary_type_id' => 'Secondary type and grade are required for secondary students.',
                'secondary_grade' => 'Secondary type and grade are required for secondary students.',
            ]);
        }

        $grade = SecondaryGrade::from($data['secondary_grade']);

        // For 2nd and 3rd grades, section is required
        if (in_array($grade, [SecondaryGrade::SECOND, SecondaryGrade::THIRD])) {
            if (!isset($data['secondary_section'])) {
                throw ValidationException::withMessages([
                    'secondary_section' => 'Section is required for 2nd and 3rd grades.',
                ]);
            }
        }

        // For 3rd grade scientific section, branch is required
        if ($grade === SecondaryGrade::THIRD && 
            isset($data['secondary_section']) && 
            $data['secondary_section'] === SecondarySection::SCIENTIFIC->value) {
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
        return University::orderBy('name')->get();
    }

    /**
     * Get colleges for a specific university
     */
    public function getCollegesByUniversity(int $universityId)
    {
        return College::where('university_id', $universityId)
            ->orderBy('name')
            ->get();
    }

    /**
     * Get grades for a specific college
     */
    public function getGradesByCollege(int $collegeId)
    {
        return Grade::where('college_id', $collegeId)
            ->orderBy('level')
            ->get();
    }

    /**
     * Get secondary types
     */
    public function getSecondaryTypes()
    {
        return SecondaryType::active()->orderBy('name')->get();
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