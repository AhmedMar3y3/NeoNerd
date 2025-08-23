<?php
namespace App\Http\Resources\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user         = Auth::user();
        $isSubscribed = $user ? $user->subscriptions()->where('course_id', $this->id)->exists() : false;
        return [
            'id'            => $this->course->id,
            'title'         => $this->course->title,
            'image'         => $this->course->image ?? env('APP_URL') . '/defaults/course.png',
            'rating'        => $this->course->rating,
            'is_free'       => $this->course->is_free,
            'subject_id'    => $this->course->subject_id,
            'subject_name'  => $this->course->subject->name,
            'doctor_name'   => $this->course->doctor->name,
            'doctor_image'  => $this->course->doctor->image ?? env('APP_URL') . '/defaults/profile.webp',
            'is_subscribed' => $isSubscribed,
        ];
    }
}
