<?php

namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;

class UpdateSettingsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'linkedIn'               => [
                'required',
                'url',
            ],

            'facebook'               => [
                'required',
                'url',
            ],
            'instagram' => [
                'required',
                'url',
            ],

            'google'               => [
                'required',
                'url',
            ],

            'x'               => [
                'required',
                'url',
            ],

            'telegram'               => [
                'required',
                'url',
            ],

            'phone'         => [
                'required',
                'string',
                'min:11',
                'max:15'
            ],

            'android_version' => [
                'required',
                'string',
                'max:50'
            ],

            'ios_version' => [
                'required',
                'string',
                'max:50'
            ],
        ];
    }
}
