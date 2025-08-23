<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscribedCourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'price'         => $this->price,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'doctor'        => $this->doctor?->name,
            'ratings_avg'   => $this->ratings_avg,
            'ratings_count' => $this->ratings_count,
            'units'         => UniteResource::collection($this->whenLoaded('units')), // مع الدروس
        ];
    }
}
