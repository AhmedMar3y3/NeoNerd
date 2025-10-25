<?php

namespace App\Notifications;

use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;

class NewLessonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lesson;
    protected $course;

    /**
     * Create a new notification instance.
     */
    public function __construct(Lesson $lesson, Course $course)
    {
        $this->lesson = $lesson;
        $this->course = $course;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        // Send FCM notification
        $this->sendFcmNotification($notifiable);
        
        return [
            'lesson_id' => $this->lesson->id,
            'lesson_title' => $this->lesson->title,
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'unit_title' => $this->lesson->unit->title,
            'doctor_name' => $this->course->doctor->name,
            'message' => "تم إضافة درس جديد: {$this->lesson->title} في الكورس: {$this->course->title}",
            'type' => 'new_lesson',
        ];
    }

    /**
     * Send FCM notification
     */
    private function sendFcmNotification($notifiable)
    {
        if (!$notifiable->fcm_token) {
            return;
        }

        try {
            $message = CloudMessage::withTarget('token', $notifiable->fcm_token)
                ->withNotification(FirebaseNotification::create(
                    'درس جديد متاح',
                    "تم إضافة درس جديد: {$this->lesson->title} في الكورس: {$this->course->title}"
                ))
                ->withData([
                    'lesson_id' => (string) $this->lesson->id,
                    'course_id' => (string) $this->course->id,
                    'type' => 'new_lesson',
                    'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                ]);

            Firebase::messaging()->send($message);
        } catch (\Exception $e) {
            \Log::error('FCM notification failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'lesson_id' => $this->lesson->id,
            'lesson_title' => $this->lesson->title,
            'course_id' => $this->course->id,
            'course_title' => $this->course->title,
            'unit_title' => $this->lesson->unit->title,
            'doctor_name' => $this->course->doctor->name,
            'message' => "تم إضافة درس جديد: {$this->lesson->title} في الكورس: {$this->course->title}",
            'type' => 'new_lesson',
        ];
    }
}
