<?php

namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_id'    => $this->course_id,
            'course_title' => $this->course->title,
            'course_image' => $this->course->image,
            'course_rating'=> $this->course->rating,
            'subject_name' => $this->course->subject->name,
            'doctor_name'  => $this->course->doctor->name,
            'doctor_image' => $this->course->doctor->image ?? env('APP_URL') . '/defaults/profile.webp',
        ];
    }
}
