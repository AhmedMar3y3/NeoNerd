<?php

namespace App\Http\Resources;

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
            'id'         => $this->id,
            'course_id'  => $this->course_id ,
            'user_id'    => $this->user_id,
            'course'     => new CourseResource($this->whenLoaded('course'))?? null,

        ];
    }
}
