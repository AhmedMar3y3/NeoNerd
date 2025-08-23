<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailsResource extends JsonResource
{
    private $isSubscribed;

    public function __construct($resource, $isSubscribed = false)
    {
        parent::__construct($resource);
        $this->isSubscribed = $isSubscribed;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'image'         => $this->image ? asset('storage/' . $this->image) : null,
            'rating'        => $this->rating,
            'ratings_count' => $this->ratings_count,
            'doctor_name'   => $this->doctor->name,
            'is_subscribed' => $this->isSubscribed,
            'units'         => $this->isSubscribed 
                ? \App\Http\Resources\UniteWithLessonResource::collection($this->whenLoaded('units'))
                : \App\Http\Resources\UnitWithoutLessonsResource::collection($this->whenLoaded('units')),
        ];

        // Add price for unsubscribed users
        if (!$this->isSubscribed) {
            $data['price'] = $this->price;
            $data['is_free'] = (bool) $this->is_free;
        }

        return $data;
    }
}
