<?php

namespace App\Http\Requests\Doctor\Unit;

use App\Http\Requests\BaseRequest;

class StoreUnitRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الوحدة مطلوب',
            'title.string' => 'عنوان الوحدة يجب أن يكون نص',
            'title.max' => 'عنوان الوحدة لا يمكن أن يتجاوز 255 حرف',
        ];
    }
}
