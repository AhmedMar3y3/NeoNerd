<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Requests\BaseRequest;

class CompleteProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'academic_level' => 'required|string|in:high_school,undergraduate,postgraduate',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
