<?php

namespace App\Http\Requests\Doctor\Profile;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
        
            'name' => [
                'nullable',
                'string',
            ],
            'email' => [
                'nullable',
                'email',
                'unique:doctors,email,' . Auth::guard('doctor')->id(),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:png,jpg,jpeg',
                'max:5000',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:15'
            ],
            'specialization' => [
                'nullable',
                'string',
                'max:255'
            ],

            'bio' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'university_id' => [
                'nullable',
                'exists:universities,id'
            ]
        ];
    }
}