<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Requests\BaseRequest;

class VerifyPhoneRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|regex:/^20\d{10}$/',
            'code' => 'required|integer|digits:6',
        ];
    }
}
