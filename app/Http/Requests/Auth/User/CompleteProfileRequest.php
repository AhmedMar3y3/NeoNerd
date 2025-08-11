<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Requests\BaseRequest;
use App\Enums\AcademicLevel;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use App\Enums\ScientificBranch;

class CompleteProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'academic_level' => 'required|string|in:' . implode(',', array_column(AcademicLevel::cases(), 'value')),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // University flow validation
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
                'secondary_type_id' => 'required|exists:secondary_types,id',
                'secondary_grade' => 'required|string|in:' . implode(',', array_column(SecondaryGrade::cases(), 'value')),
            ]);

            $secondaryGrade = $this->input('secondary_grade');
            if (in_array($secondaryGrade, [SecondaryGrade::SECOND->value, SecondaryGrade::THIRD->value])) {
                $rules['secondary_section'] = 'required|string|in:' . implode(',', array_column(SecondarySection::cases(), 'value'));
            }

            if ($secondaryGrade === SecondaryGrade::THIRD->value &&
                $this->input('secondary_section') === SecondarySection::SCIENTIFIC->value) {
                $rules['scientific_branch'] = 'required|string|in:' . implode(',', array_column(ScientificBranch::cases(), 'value'));
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required' => 'الاسم الأخير مطلوب',
            'gender.required' => 'الجنس مطلوب',
            'academic_level.required' => 'المستوى الأكاديمي مطلوب',
            'university_id.required' => 'الجامعة مطلوبة',
            'college_id.required' => 'الكلية مطلوبة',
            'grade_id.required' => 'السنة الدراسية مطلوبة',
            'secondary_type_id.required' => 'نوع المدرسة الثانوية مطلوب',
            'secondary_grade.required' => 'الصف الدراسي مطلوب',
            'secondary_section.required' => 'القسم مطلوب',
            'scientific_branch.required' => 'الشعبة العلمية مطلوبة',
        ];
    }
}
