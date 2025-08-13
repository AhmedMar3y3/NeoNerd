<?php

namespace App\Http\Requests\Auth\User;

use App\Enums\AcademicLevel;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;
use App\Http\Requests\BaseRequest;

class CompleteProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'academic_level' => 'required|string|in:' . implode(',', array_column(AcademicLevel::cases(), 'value')),
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
        ];

        if ($this->input('academic_level') === AcademicLevel::UNIVERSITY->value) {
            $rules = array_merge($rules, [
                'university_id' => 'required|exists:universities,id',
                'college_id' => 'required|exists:colleges,id',
                'grade_id' => 'required|exists:grades,id',
            ]);
        }

        // Secondary flow validation
        if ($this->input('academic_level') === AcademicLevel::SECONDARY->value) {
            $rules = array_merge($rules, [
                'secondary_type' => 'required|string|in:' . implode(',', array_column(SecondaryType::cases(), 'value')),
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
        }

        return $rules;
    }
}
