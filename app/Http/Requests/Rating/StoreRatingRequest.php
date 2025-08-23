<?php

namespace App\Http\Requests\Rating;

use App\Http\Requests\BaseRequest;

class StoreRatingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'review' => 'nullable|string|max:1000',
            'rating' => 'required|integer|in:1,2,3,4,5',
        ];
    }
}
