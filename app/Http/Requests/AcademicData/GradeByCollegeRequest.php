<?php

namespace App\Http\Requests\AcademicData;

use App\Http\Requests\BaseRequest;

class GradeByCollegeRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'college_id' => 'required|exists:colleges,id'
        ];
    }
}
