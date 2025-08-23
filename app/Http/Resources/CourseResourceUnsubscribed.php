<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResourceUnsubscribed extends JsonResource
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
            'rating'         => $this->rating,

            'ratings_avg'   => $this->ratings_avg,
            'ratings_count' => $this->ratings_count,
            'units with lessons'         => UniteWithLessonResource::collection($this->whenLoaded('units')), // مع الدروس

        ];
    }
}
