<?php

namespace App\Http\Requests\Admin\Subject;

use App\Enums\AcademicLevel;
use App\Enums\SubjectType;
use App\Enums\Term;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'term' => 'required|in:' . implode(',', array_column(Term::cases(), 'value')),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'academic_level' => 'required|in:' . implode(',', array_column(AcademicLevel::cases(), 'value')),
            'is_active' => 'boolean',
        ];

                            // Conditional validation based on academic level
                    if ($this->input('academic_level') === AcademicLevel::UNIVERSITY->value) {
                        $rules = array_merge($rules, [
                            // University subjects don't have type (scientific, literal, both)
                            'type' => 'nullable|prohibited',
                            'college_type_id' => 'required|exists:college_types,id',
                            'grade_level' => 'required|integer|min:1|max:6',
                            // Clear secondary fields for university subjects
                            'secondary_type' => 'nullable|prohibited',
                            'secondary_grade' => 'nullable|prohibited',
                            'secondary_section' => 'nullable|prohibited',
                        ]);
                    } elseif ($this->input('academic_level') === AcademicLevel::SECONDARY->value) {
                        $rules = array_merge($rules, [
                            'secondary_type' => 'required|in:' . implode(',', array_column(SecondaryType::cases(), 'value')),
                            'secondary_grade' => 'required|in:' . implode(',', array_column(SecondaryGrade::cases(), 'value')),
                            'secondary_section' => 'nullable|in:' . implode(',', array_column(SecondarySection::cases(), 'value')),
                            // Clear university fields for secondary subjects
                            'college_type_id' => 'nullable|prohibited',
                            'grade_level' => 'nullable|prohibited',
                        ]);

                        // Additional validation for secondary subjects based on grade
                        $secondaryGrade = $this->input('secondary_grade');
                        if ($secondaryGrade === SecondaryGrade::SECOND->value || $secondaryGrade === SecondaryGrade::THIRD->value) {
                            $rules['secondary_section'] = 'required|in:' . implode(',', array_column(SecondarySection::cases(), 'value'));
                            $rules['type'] = 'required|in:' . implode(',', array_column(SubjectType::cases(), 'value'));
                        } elseif ($secondaryGrade === SecondaryGrade::FIRST->value) {
                            // First grade doesn't have type or section
                            $rules['type'] = 'nullable|prohibited';
                            $rules['secondary_section'] = 'nullable|prohibited';
                        }
                    }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المادة مطلوب',
            'name.string' => 'اسم المادة يجب أن يكون نص',
            'name.max' => 'اسم المادة لا يمكن أن يتجاوز 255 حرف',
            
            'term.required' => 'الفصل الدراسي مطلوب',
            'term.in' => 'الفصل الدراسي غير صحيح',
            
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'نوع الصورة غير مدعوم. الأنواع المدعومة: jpeg, png, jpg, gif, webp',
            'image.max' => 'حجم الصورة لا يمكن أن يتجاوز 2 ميجابايت',
            
            'academic_level.required' => 'المستوى الأكاديمي مطلوب',
            'academic_level.in' => 'المستوى الأكاديمي غير صحيح',
            
                                    'type.required' => 'نوع المادة مطلوب للصف الثاني والثالث الثانوي',
                        'type.in' => 'نوع المادة غير صحيح',
                        'type.prohibited' => 'نوع المادة غير مطلوب للمواد الجامعية والصف الأول الثانوي',
            
            'college_type_id.required' => 'نوع الكلية مطلوب للمواد الجامعية',
            'college_type_id.exists' => 'نوع الكلية غير موجود',
            'college_type_id.prohibited' => 'نوع الكلية غير مطلوب للمواد الثانوية',
            
            'grade_level.required' => 'مستوى السنة الدراسية مطلوب للمواد الجامعية',
            'grade_level.integer' => 'مستوى السنة الدراسية يجب أن يكون رقم',
            'grade_level.min' => 'مستوى السنة الدراسية يجب أن يكون 1 على الأقل',
            'grade_level.max' => 'مستوى السنة الدراسية لا يمكن أن يتجاوز 6',
            'grade_level.prohibited' => 'مستوى السنة الدراسية غير مطلوب للمواد الثانوية',
            
            'secondary_type.required' => 'نوع المدرسة الثانوية مطلوب للمواد الثانوية',
            'secondary_type.in' => 'نوع المدرسة الثانوية غير صحيح',
            'secondary_type.prohibited' => 'نوع المدرسة الثانوية غير مطلوب للمواد الجامعية',
            
            'secondary_grade.required' => 'الصف الثانوي مطلوب للمواد الثانوية',
            'secondary_grade.in' => 'الصف الثانوي غير صحيح',
            'secondary_grade.prohibited' => 'الصف الثانوي غير مطلوب للمواد الجامعية',
            
                                    'secondary_section.required' => 'القسم مطلوب للصف الثاني والثالث الثانوي',
                        'secondary_section.in' => 'القسم غير صحيح',
                        'secondary_section.prohibited' => 'القسم غير مطلوب للمواد الجامعية والصف الأول الثانوي',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default values
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
