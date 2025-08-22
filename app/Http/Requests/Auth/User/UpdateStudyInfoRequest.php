<?php
namespace App\Http\Requests\Auth\User;

use App\Enums\AcademicLevel;
use App\Enums\ScientificBranch;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\SecondaryType;
use App\Http\Requests\BaseRequest;

class UpdateStudyInfoRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'academic_level' => 'nullable|string|in:' . implode(',', array_column(AcademicLevel::cases(), 'value')),
        ];

        $academicLevel = $this->input('academic_level');

        if ($academicLevel === AcademicLevel::UNIVERSITY->value) {
            $rules = array_merge($rules, [
                'university_id' => 'required|exists:universities,id',
                'college_id'    => 'required|exists:colleges,id',
                'grade_id'      => 'required|exists:grades,id',
            ]);
        } elseif ($academicLevel === AcademicLevel::SECONDARY->value) {
            $rules = array_merge($rules, [
                'secondary_type'  => 'required|string|in:' . implode(',', array_column(SecondaryType::cases(), 'value')),
                'secondary_grade' => 'required|string|in:' . implode(',', array_column(SecondaryGrade::cases(), 'value')),
            ]);

            $secondaryGrade = $this->input('secondary_grade');
            if ($secondaryGrade === SecondaryGrade::FIRST->value) {
                $rules['secondary_section'] = 'prohibited|string|in:' . implode(',', array_column(SecondarySection::cases(), 'value'));
                $rules['scientific_branch'] = 'prohibited|string|in:' . implode(',', array_column(ScientificBranch::cases(), 'value'));
            }
            if (in_array($secondaryGrade, [SecondaryGrade::SECOND->value, SecondaryGrade::THIRD->value])) {
                $rules['secondary_section'] = 'required|string|in:' . implode(',', array_column(SecondarySection::cases(), 'value'));
            } else {
                $rules['secondary_section'] = 'prohibited|string|in:' . implode(',', array_column(SecondarySection::cases(), 'value'));
            }

            if ($secondaryGrade === SecondaryGrade::THIRD->value &&
                $this->input('secondary_section') === SecondarySection::SCIENTIFIC->value) {
                $rules['scientific_branch'] = 'required|string|in:' . implode(',', array_column(ScientificBranch::cases(), 'value'));
            } else {
                $rules['scientific_branch'] = 'prohibited|string|in:' . implode(',', array_column(ScientificBranch::cases(), 'value'));
            }
        } else {
            $user = $this->user();

            if ($user->isUniversityStudent()) {
                $rules = array_merge($rules, [
                    'university_id' => 'nullable|exists:universities,id',
                    'college_id'    => 'nullable|exists:colleges,id',
                    'grade_id'      => 'nullable|exists:grades,id',
                ]);
            } else {
                $rules = array_merge($rules, [
                    'secondary_type'    => 'nullable|string|in:' . implode(',', array_column(SecondaryType::cases(), 'value')),
                    'secondary_grade'   => 'nullable|string|in:' . implode(',', array_column(SecondaryGrade::cases(), 'value')),
                    'secondary_section' => 'nullable|string|in:' . implode(',', array_column(SecondarySection::cases(), 'value')),
                    'scientific_branch' => 'nullable|string|in:' . implode(',', array_column(ScientificBranch::cases(), 'value')),
                ]);

                $this->validateSecondaryUpdateRules($rules);
            }
        }

        return $rules;
    }

    private function validateSecondaryUpdateRules(array &$rules): void
    {
        $user             = $this->user();
        $secondaryGrade   = $this->input('secondary_grade', $user->secondary_grade?->value);
        $secondarySection = $this->input('secondary_section', $user->secondary_section?->value);

        if ($secondaryGrade === SecondaryGrade::FIRST->value) {
            $rules['secondary_section'] = 'prohibited';
            $rules['scientific_branch'] = 'prohibited';
        }

        if ($secondarySection === SecondarySection::LITERAL->value) {
            $rules['scientific_branch'] = 'prohibited';
        }

        if ($secondaryGrade !== SecondaryGrade::THIRD->value || $secondarySection !== SecondarySection::SCIENTIFIC->value) {
            $rules['scientific_branch'] = 'prohibited';
        }
    }

    public function messages(): array
    {
        return [
            'academic_level.in'            => 'Academic level must be either university or secondary.',
            'university_id.required'       => 'University is required for university students.',
            'university_id.exists'         => 'Selected university does not exist.',
            'college_id.required'          => 'College is required for university students.',
            'college_id.exists'            => 'Selected college does not exist.',
            'grade_id.required'            => 'Grade is required for university students.',
            'grade_id.exists'              => 'Selected grade does not exist.',
            'secondary_type.required'      => 'Secondary type is required for secondary students.',
            'secondary_type.in'            => 'Secondary type must be either arabic or language.',
            'secondary_grade.required'     => 'Secondary grade is required for secondary students.',
            'secondary_grade.in'           => 'Secondary grade must be first, second, or third.',
            'secondary_section.required'   => 'Secondary section is required for second and third grades.',
            'secondary_section.in'         => 'Secondary section must be either literal or scientific.',
            'secondary_section.prohibited' => 'Secondary section is not applicable for first grade.',
            'scientific_branch.required'   => 'Scientific branch is required for third grade scientific section.',
            'scientific_branch.in'         => 'Scientific branch must be either science or math.',
            'scientific_branch.prohibited' => 'Scientific branch is not applicable for this grade/section combination.',
        ];
    }
}
