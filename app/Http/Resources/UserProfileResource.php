<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'gender' => $this->gender?->value,
            'academic_level' => $this->academic_level?->value,
            'image' => $this->image,
            'is_verified' => $this->is_verified,
            'is_active' => $this->is_active,
            'is_academic_details_set' => $this->is_academic_details_set,
            
            // University flow data
            'university' => $this->when($this->university, [
                'id' => $this->university?->id,
                'name' => $this->university?->name,
            ]),
            'college' => $this->when($this->college, [
                'id' => $this->college?->id,
                'name' => $this->college?->name,
            ]),
            'grade' => $this->when($this->grade, [
                'id' => $this->grade?->id,
                'name' => $this->grade?->name,
                'level' => $this->grade?->level,
            ]),
            
            // Secondary flow data
            'secondary_school' => $this->when($this->secondarySchool, [
                'id' => $this->secondarySchool?->id,
                'name' => $this->secondarySchool?->name,
                'type' => $this->secondarySchool?->type?->value,
            ]),
            'secondary_grade' => $this->secondary_grade?->value,
            'secondary_section' => $this->secondary_section?->value,
            'scientific_branch' => $this->scientific_branch?->value,
            
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
