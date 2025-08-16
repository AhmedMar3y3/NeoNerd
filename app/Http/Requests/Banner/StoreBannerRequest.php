<?php

namespace App\Http\Requests\Banner;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
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
