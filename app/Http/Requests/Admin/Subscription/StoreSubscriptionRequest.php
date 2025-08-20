<?php

namespace App\Http\Requests\Admin\Subscription;

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
                Rule::in([SubscriptionType::COURSE->value, SubscriptionType::BOOK->value]),
            ],
            'course_id' => [
                'nullable',
                'required_if:subscription_type,' . SubscriptionType::COURSE->value,
                'exists:courses,id',
                'prohibited_if:subscription_type,' . SubscriptionType::BOOK->value,
            ],
            'book_id' => [
                'nullable',
                'required_if:subscription_type,' . SubscriptionType::BOOK->value,
                'exists:books,id',
                'prohibited_if:subscription_type,' . SubscriptionType::COURSE->value,
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
            'course_id.required_if' => 'الدورة مطلوبة عند اختيار نوع الاشتراك دورة',
            'course_id.exists' => 'الدورة غير موجودة',
            'course_id.prohibited_if' => 'لا يمكن اختيار دورة عند الاشتراك في كتاب',
            'book_id.required_if' => 'الكتاب مطلوب عند اختيار نوع الاشتراك كتاب',
            'book_id.exists' => 'الكتاب غير موجود',
            'book_id.prohibited_if' => 'لا يمكن اختيار كتاب عند الاشتراك في دورة',
            'is_active.boolean' => 'حالة الاشتراك يجب أن تكون صحيح أو خطأ',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional custom validation
            if ($this->subscription_type === SubscriptionType::COURSE->value && $this->course_id) {
                $course = \App\Models\Course::find($this->course_id);
                if (!$course || !$course->is_active) {
                    $validator->errors()->add('course_id', 'الدورة غير متاحة للاشتراك');
                }
            }

            if ($this->subscription_type === SubscriptionType::BOOK->value && $this->book_id) {
                $book = \App\Models\Book::find($this->book_id);
                if (!$book || !$book->is_active) {
                    $validator->errors()->add('book_id', 'الكتاب غير متاح للاشتراك');
                }
            }
        });
    }
}
