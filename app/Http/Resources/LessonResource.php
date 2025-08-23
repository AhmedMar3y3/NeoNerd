<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'is_free'   => (bool) $this->is_free,
            'video_url' => $this->video_url,
            'duration'  => $this->duration,
            'has_file'  => (bool) $this->has_file,
            'file'      => $this->file ? asset('storage/' . $this->file) : null,

            // If you want to include unit info

        ];
    }
}
