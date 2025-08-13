<?php

namespace App\Observers;

use App\Models\Course;
use App\Models\Rating;

class RatingObserver
{
    public function created(Rating $rating)
    {
        $this->updateCourseRating($rating->course_id);
    }

    public function deleted(Rating $rating)
    {
        $this->updateCourseRating($rating->course_id);
    }

    protected function updateCourseRating($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $averageRating = Rating::where('course_id', $course->id)->avg('rating');
            $ratingsCount = Rating::where('course_id', $course->id)->count();
            $course->rating = $averageRating ? round($averageRating, 2) : null;
            $course->ratings_count = $ratingsCount;
            $course->save();
        }
    }
}
