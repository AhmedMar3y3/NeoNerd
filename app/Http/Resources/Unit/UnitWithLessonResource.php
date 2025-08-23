<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Request;
use App\Http\Resources\Lesson\LessonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitWithLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
        ];
    }
}
