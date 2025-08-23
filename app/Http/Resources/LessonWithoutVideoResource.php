<?php

namespace App\Http\Resources;

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
            'is_free'   => (bool) $this->is_free,
            'duration'  => $this->duration,
            'has_file'  => (bool) $this->has_file,
            'file'      => $this->file ? asset('storage/' . $this->file) : null,
        ];
    }
}
