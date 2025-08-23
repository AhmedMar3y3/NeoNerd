<?php
namespace App\Http\Resources\Course;

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
            'id'            => $this->id,
            'title'         => $this->title,
            'image'         => $this->image ?? env('APP_URL') . '/defaults/subject.png',
            'rating'        => $this->rating,
            'is_free'       => $this->is_free,
            'subject_id'    => $this->subject_id,
            'subject_name'  => $this->subject->name,
            'doctor_name'   => $this->doctor->name,
            'doctor_image'  => $this->doctor->image ?? env('APP_URL') . '/defaults/profile.webp',
        ];

    }
}
