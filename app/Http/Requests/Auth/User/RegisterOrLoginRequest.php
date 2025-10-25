<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Requests\BaseRequest;

class RegisterOrLoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'phone'     => 'required|string|regex:/^20\d{10}$/',
            'fcm_token' => 'nullable|string',
        ];
    }
}
    