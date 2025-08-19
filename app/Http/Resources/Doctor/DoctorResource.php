<?php
namespace App\Http\Resources\Doctor;

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
            'image'          => $this->image ?? env('APP_URL') . '/defaults/profile.webp',
            'is_active'      => (bool) $this->is_active,
            'is_partner'     => (bool) $this->is_partner,
            'university_id'  => $this->university_id,
        ];
    }
}
