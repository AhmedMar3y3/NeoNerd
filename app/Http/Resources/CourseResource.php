<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title'          => $this->title ?? null,
            'image'          => $this->image ? url('storage/' . $this->image) : null,
            'description'    => $this->description ?? null,
            'rating'         => $this->rating ?? 0,
            'ratings_count'  => $this->ratings_count ?? 0,
            'price'          => $this->price ?? null,
            'is_free'        => (bool) $this->is_free,
            'is_active'      => (bool) $this->is_active,
            'subject_id'     => $this->subject_id ?? null,
            'doctor_id'      => $this->doctor_id ?? null,

            // (optional) load relations if eager loaded
            'subject'        => new SubjectResource($this->whenLoaded('subject')),
            'doctor'         => new DoctorResource($this->whenLoaded('doctor')),

              ];
    }
}
