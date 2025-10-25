<?php

namespace App\Http\Resources\Notification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'lesson_id' => $this->data['lesson_id'] ?? null,
            'course_id' => $this->data['course_id'] ?? null,
            'course_title' => $this->data['course_title'] ?? null,
            'doctor_name' => $this->data['doctor_name'] ?? null,
            'message' => $this->data['message'] ?? null,
            'type' => $this->data['type'] ?? null,
            'is_read' => $this->read_at !== null,
        ];
    }
}
