<?php

namespace App\Http\Requests\Auth\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudyInfoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'university_id' => 'nullable|string|exists:universities,id',
            'college_id' => 'nullable|string|exists:colleges,id',
            'grade_id' => 'nullable|string|exists:grades,id',
        ];
    }
}
