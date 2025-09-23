<?php

namespace App\Http\Resources\Unit;

use Illuminate\Http\Request;
use App\Http\Resources\Lesson\LessonResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UnitWithLessonResource extends JsonResource
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
        return [
            'id'      => $this->id,
            'title'   => $this->title,
            'lessons' => $this->whenLoaded('lessons', function () {
                return $this->lessons->map(function ($lesson) {
                    return new LessonResource($lesson, $this->isSubscribed);
                });
            }),
        ];
    }
}
