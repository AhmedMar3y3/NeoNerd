<?php

namespace App\Http\Resources\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'id'        => $this->id,
            'title'     => $this->title,
            'is_free'   => $this->isSubscribed ? 1 : $this->is_free,
            'video_url' => $this->video_url,
            'duration'  => $this->duration,
            // 'has_file'  => (bool) $this->has_file,
            // 'file'      => $this->file ? asset('storage/' . $this->file) : null,
        ];
    }
}
