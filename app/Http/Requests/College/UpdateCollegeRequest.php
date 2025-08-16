<?php

namespace App\Http\Requests\College;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollegeRequest extends FormRequest
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
            'college_type_id' => 'nullable|exists:college_types,id',
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
            'name.required' => 'اسم الكلية مطلوب',
            'name.string' => 'اسم الكلية يجب أن يكون نص',
            'name.max' => 'اسم الكلية يجب أن لا يتجاوز 255 حرف',
            'college_type_id.exists' => 'نوع الكلية المحدد غير موجود',
        ];
    }
}
