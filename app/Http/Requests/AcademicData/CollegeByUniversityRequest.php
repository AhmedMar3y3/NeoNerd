<?php

namespace App\Http\Requests\AcademicData;

use App\Http\Requests\BaseRequest;

class CollegeByUniversityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'university_id' => 'required|exists:universities,id'
        ];
    }
}
