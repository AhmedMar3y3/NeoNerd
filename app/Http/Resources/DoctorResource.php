<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone ?? null,
            'specialization' => $this->specialization ?? null,
            'bio'            => $this->bio ?? null,
            'image'          => $this->image
                ? url('storage/' . $this->image)
                : null,
            'is_active'      => (bool) $this->is_active,
            'is_partner'     => (bool) $this->is_partner,
            'university_id'  => $this->university_id,
            ];
    }
}
