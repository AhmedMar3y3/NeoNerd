<?php

namespace App\Http\Requests\Doctor\Course;

use App\Http\Requests\BaseRequest;

class UpdateCourseRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5000',
            ],
            'price' => [
                'required',
                'integer',
                'min:0',
            ],
            'is_free' => [
                'boolean',
            ],
            'is_active' => [
                'boolean',
            ],
            'subject_id' => [
                'required',
                'exists:subjects,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الدورة مطلوب',
            'title.string' => 'عنوان الدورة يجب أن يكون نص',
            'title.max' => 'عنوان الدورة لا يمكن أن يتجاوز 255 حرف',
            'description.string' => 'وصف الدورة يجب أن يكون نص',
            'description.max' => 'وصف الدورة لا يمكن أن يتجاوز 1000 حرف',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'صيغة الصورة يجب أن تكون PNG, JPG, أو JPEG',
            'image.max' => 'حجم الصورة لا يمكن أن يتجاوز 5 ميجابايت',
            'price.required' => 'سعر الدورة مطلوب',
            'price.integer' => 'سعر الدورة يجب أن يكون رقم صحيح',
            'price.min' => 'سعر الدورة لا يمكن أن يكون أقل من 0',
            'is_free.boolean' => 'حقل مجاني يجب أن يكون صحيح أو خطأ',
            'is_active.boolean' => 'حقل نشط يجب أن يكون صحيح أو خطأ',
            'subject_id.required' => 'المادة الدراسية مطلوبة',
            'subject_id.exists' => 'المادة الدراسية غير موجودة',
        ];
    }
}
