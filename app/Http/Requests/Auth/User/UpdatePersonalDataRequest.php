<?php

namespace App\Http\Requests\Auth\User;

use App\Http\Requests\BaseRequest;

class UpdatePersonalDataRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => 'nullable|string',

        ];
    }
}
