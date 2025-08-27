<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password:doctor'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}