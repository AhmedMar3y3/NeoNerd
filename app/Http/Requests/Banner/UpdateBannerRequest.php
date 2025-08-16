<?php

namespace App\Http\Requests\Banner;

use App\Http\Requests\BaseRequest;

class UpdateBannerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'nullable',
                'string',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg',
                'max:5000'
            ]
        ];
    }
}
