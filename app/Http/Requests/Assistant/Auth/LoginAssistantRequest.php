<?php

namespace App\Http\Requests\Assistant\Auth;

use App\Http\Requests\BaseRequest;

class LoginAssistantRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:assistants,email',
            'password' => 'required|string',
        ];
    }
}
