<?php

namespace App\Http\Requests\Doctor\Auth;

use App\Http\Requests\BaseRequest;

class LoginDoctorRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:doctors,email',
            'password' => 'required|string',
        ];
    }
}
