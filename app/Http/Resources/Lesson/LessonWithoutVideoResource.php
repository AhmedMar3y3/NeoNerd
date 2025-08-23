<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonWithoutVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'is_free'   => $this->is_free,
            ...($this->is_free ? ['video_url' => $this->video_url] : []),
            'duration'  => $this->duration,
            // 'has_file'  => $this->has_file,
            // 'file'      => $this->file ? asset('storage/' . $this->file) : null,
        ];
    }
}
