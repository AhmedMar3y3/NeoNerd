<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Unit\UnitWithLessonResource;
use App\Http\Resources\Unit\UnitWithoutLessonsResource;

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
            'image'         => $this->image ?? env('APP_URL') . '/defaults/course.png',
            'subject_name'  => $this->subject->name,
            'rating'        => $this->rating,
            'ratings_count' => $this->ratings_count,
            'doctor_name'   => $this->doctor->name,
            'doctor_image'  => $this->doctor->image ?? env('APP_URL') . '/defaults/profile.webp',
            'doctor_bio'    => $this->doctor->specialization . ' - ' . $this->doctor->university->name,
            'is_favorited' => $this->isFavorited(),
            'units'         => $this->isSubscribed 
                ? $this->whenLoaded('units', function () {
                    return $this->units->map(function ($unit) {
                        return new UnitWithLessonResource($unit, $this->isSubscribed);
                    });
                })
                : UnitWithoutLessonsResource::collection($this->whenLoaded('units')),
        ];

        if (!$this->isSubscribed) {
            $data['price'] = $this->price;
        }

        return $data;
    }
}
