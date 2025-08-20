<?php

namespace App\Http\Requests\Admin\Doctor;

use App\Http\Requests\BaseRequest;

class StoreDoctorRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:doctors,email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ],
            'is_partner' => [
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم الطبيب مطلوب',
            'name.string' => 'اسم الطبيب يجب أن يكون نص',
            'name.max' => 'اسم الطبيب لا يمكن أن يتجاوز 255 حرف',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'email.max' => 'البريد الإلكتروني لا يمكن أن يتجاوز 255 حرف',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب أن تكون نص',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.max' => 'كلمة المرور لا يمكن أن تتجاوز 255 حرف',
            'is_partner.boolean' => 'حقل الشريك يجب أن يكون صحيح أو خطأ',
        ];
    }
}
