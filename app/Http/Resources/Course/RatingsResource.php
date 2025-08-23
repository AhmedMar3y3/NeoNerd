<?php
namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingsResource extends JsonResource
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
            'user_id'    => $this->user_id,
            'user_name'  => $this->user->first_name . ' ' . $this->user->last_name,
            'user_image' => $this->user->image ?? env('APP_URL') . '/defaults/profile.webp',
            'rating'     => $this->rating,
            'review'     => $this->review,
        ];
    }
}
