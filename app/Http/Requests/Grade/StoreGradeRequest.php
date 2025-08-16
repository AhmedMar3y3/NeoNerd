<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:1|max:10',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المرحلة مطلوب',
            'name.string' => 'اسم المرحلة يجب أن يكون نص',
            'name.max' => 'اسم المرحلة يجب أن لا يتجاوز 255 حرف',
            'level.required' => 'مستوى المرحلة مطلوب',
            'level.integer' => 'مستوى المرحلة يجب أن يكون رقم صحيح',
            'level.min' => 'مستوى المرحلة يجب أن يكون 1 على الأقل',
            'level.max' => 'مستوى المرحلة يجب أن لا يتجاوز 10',
        ];
    }
}
