<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'first_name'              => $this->first_name ?? null,
            'last_name'               => $this->last_name ?? null,
            'phone'                   => $this->phone ?? null,
            'code'                    => $this->code ?? null,
            'is_verified'             => (bool) $this->is_verified,
            'gender'                  => $this->gender ?? null,
            'academic_level'          => $this->academic_level ?? null,
            'image'                   => $this->image
                ? url('storage/' . $this->image)
                : null,
            'is_active'               => (bool) $this->is_active,
            'fcm_token'               => $this->fcm_token ?? null,
            'is_academic_details_set' => (bool) $this->is_academic_details_set,

            // Relations (nullable)
            'university_id'           => $this->university_id ?? null,
            'college_id'              => $this->college_id ?? null,
            'grade_id'                => $this->grade_id ?? null,

            // Secondary flow fields
            'secondary_type'          => $this->secondary_type ?? null,
            'secondary_grade'         => $this->secondary_grade ?? null,
            'secondary_section'       => $this->secondary_section ?? null,
            'scientific_branch'       => $this->scientific_branch ?? null,
            ];
    }
}
