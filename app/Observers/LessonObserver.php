<?php

namespace App\Observers;

use App\Models\Lesson;
use App\Models\User;
use App\Notifications\NewLessonNotification;

class LessonObserver
{
    /**
     * Handle the Lesson "created" event.
     */
    public function created(Lesson $lesson): void
    {
        $lesson->load(['unit.course.doctor']);
        $course = $lesson->unit->course;

        $subscribedUsers = User::whereHas('activeSubscriptions', function ($query) use ($course) {
            $query->where('course_id', $course->id);
        })->get();

        foreach ($subscribedUsers as $user) {
            $user->notify(new NewLessonNotification($lesson, $course));
        }
    }

    /**
     * Handle the Lesson "updated" event.
     */
    public function updated(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "deleted" event.
     */
    public function deleted(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "restored" event.
     */
    public function restored(Lesson $lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "force deleted" event.
     */
    public function forceDeleted(Lesson $lesson): void
    {
        //
    }
}
