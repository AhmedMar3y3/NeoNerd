<?php
namespace App\Http\Resources\User;

use App\Enums\AcademicLevel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'             => $this->id,
            'full_name'      => $this->first_name . ' ' . $this->last_name,
            'phone'          => $this->phone,
            'gender'         => $this->gender->value,
            'academic_level' => $this->academic_level->value,
            'image'          => $this->image ?? env('APP_URL') . '/defaults/profile.webp',
            'is_academic_details_set' => $this->is_academic_details_set,
        ];

        if ($this->academic_level === AcademicLevel::UNIVERSITY) {
            $data['academic_details'] = [
                'university' => $this->university->name,
                'college' => $this->college->name,
                'grade' => $this->grade->name,
            ];
        } elseif ($this->academic_level === AcademicLevel::SECONDARY) {
            $data['academic_details'] = [
                'secondary_type' => $this->secondary_type?->value,
                'secondary_grade' => $this->secondary_grade?->value,
                'secondary_section' => $this->secondary_section?->value,
                'scientific_branch' => $this->scientific_branch?->value,
            ];
        } else {
            $data['academic_details'] = null;
        }

        return $data;
    }
}
