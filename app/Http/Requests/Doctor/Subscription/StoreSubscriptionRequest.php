<?php

namespace App\Http\Requests\Doctor\Subscription;

use App\Http\Requests\BaseRequest;
use App\Enums\SubscriptionType;
use Illuminate\Validation\Rule;

class StoreSubscriptionRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'subscription_type' => [
                'required',
                Rule::in([SubscriptionType::COURSE->value]),
            ],
            'course_id' => [
                'required',
                'exists:courses,id',
            ],
            'is_active' => [
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'المستخدم مطلوب',
            'user_id.exists' => 'المستخدم غير موجود',
            'subscription_type.required' => 'نوع الاشتراك مطلوب',
            'subscription_type.in' => 'نوع الاشتراك غير صحيح',
            'course_id.required' => 'الدورة مطلوبة',
            'course_id.exists' => 'الدورة غير موجودة',
            'is_active.boolean' => 'حالة الاشتراك يجب أن تكون صحيح أو خطأ',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional custom validation
            if ($this->course_id) {
                $course = \App\Models\Course::find($this->course_id);
                if (!$course || !$course->is_active) {
                    $validator->errors()->add('course_id', 'الدورة غير متاحة للاشتراك');
                }
            }
        });
    }
}
