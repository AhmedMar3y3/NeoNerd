<?php

namespace App\Http\Requests\Assistant\Subscription;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\SubscriptionType;
use Illuminate\Validation\Rule;


class StoreSubscriptionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'is_active' => 'boolean',
   'subscription_type' => [
                'required',
                Rule::in([SubscriptionType::COURSE->value]),
            ],        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'يجب اختيار المستخدم',
            'user_id.exists' => 'المستخدم المحدد غير موجود',
            'course_id.required' => 'يجب اختيار الدورة',
            'course_id.exists' => 'الدورة المحددة غير موجودة',
            'is_active.boolean' => 'قيمة الحالة غير صحيحة',
            'subscription_type.required' => 'يجب تحديد نوع الاشتراك',
            'subscription_type.in' => 'نوع الاشتراك غير صحيح',
        ];
    }
}
