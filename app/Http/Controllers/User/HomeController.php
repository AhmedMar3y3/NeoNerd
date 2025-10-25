<?php
namespace App\Http\Controllers\User;

use App\Enums\AcademicLevel;
use App\Enums\Term;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\StoreRatingRequest;
use App\Http\Resources\Course\CourseDetailsResource;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\RatingsResource;
use App\Http\Resources\Home\SubjectsResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Banner;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Subscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HttpResponses;

    public function banners()
    {
        return $this->successWithDataResponse(Banner::get(['id', 'title', 'image']));
    }

    public function getUserSubjects(Request $request)
    {
        $user = $request->user();
        if (! $user->is_academic_details_set) {
            return $this->failureResponse(__('messages.profile_completion_needed'));
        }

        $term = $request->get('term', Term::FIRST->value);
        if (! in_array($term, [Term::FIRST->value, Term::SECOND->value])) {
            return $this->failureResponse(__('messages.invalid_term'));
        }

        $subjects = Subject::getSubjectsForUser($user, Term::from($term));
        return $this->successWithDataResponse(SubjectsResource::collection($subjects));
    }

    public function getRecommendedCourses(Request $request)
    {
        $user = $request->user();
        if (! $user->is_academic_details_set) {
            return $this->failureResponse(__('messages.profile_completion_needed'));
        }

        $subjectId = $request->get('subject_id');

        $coursesQuery = $this->buildUserCoursesQuery($user, $subjectId);

        $recommendedCourses = $coursesQuery->where('is_active', true)
            ->orderBy('rating', 'desc')
            ->take(15)
            ->get();

        return $this->successWithDataResponse(CourseResource::collection($recommendedCourses));
    }

    public function getNewestCourses(Request $request)
    {
        $user = $request->user();
        if (! $user->is_academic_details_set) {
            return $this->failureResponse(__('messages.profile_completion_needed'));
        }

        $coursesQuery = $this->buildUserCoursesQuery($user);

        $newestCourses = $coursesQuery->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        return $this->successWithDataResponse(CourseResource::collection($newestCourses));
    }

    public function getCourseDetails(Request $request, $id)
    {
        $user = $request->user();

        $isSubscribed = Subscription::where('user_id', $user->id)
            ->where('course_id', $id)
            ->where('is_active', true)
            ->exists();

        if ($isSubscribed) {
            $course = Course::with([
                'units.lessons',
                'doctor',
            ])
                ->withAvg('ratings', 'rating')
                ->withCount('ratings')
                ->findOrFail($id);
        } else {
            $course = Course::with([
                'units.lessons',
                'doctor',
            ])
                ->findOrFail($id);
        }

        return $this->successWithDataResponse(new CourseDetailsResource($course, $isSubscribed));
    }

    public function courseRatings($id)
    {
        $course = Course::where('id', $id)->first();
        $course->setRelation('ratings', $course->ratings()->whereNotNull('review')->get());
        return $this->successWithDataResponse(RatingsResource::collection($course->ratings));
    }

    public function rateCourse(StoreRatingRequest $request, $id)
    {
        $user = $request->user();

        $isSubscribed = Subscription::where('user_id', $user->id)
            ->where('course_id', $id)
            ->where('is_active', true)
            ->exists();

        if (! $isSubscribed) {
            return $this->failureResponse(__('messages.subscription_required'));
        }

        $existingRating = $user->ratings()->where('course_id', $id)->first();
        if ($existingRating) {
            return $this->failureResponse(__('messages.already_rated'));
        }

        $user->ratings()->create($request->validated() + ['course_id' => $id]);
        return $this->successResponse(__('messages.added_successfully'));
    }

    public function getSubscribedCourses(Request $request)
    {
        $user = $request->user();
        $subscribedCourses = $user->subscribedCourses()->with(['subject', 'doctor'])->orderBy('created_at', 'desc')->get(); 
        return $this->successWithDataResponse(CourseResource::collection($subscribedCourses));
    }

    public function getNotifications(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(20);
        return $this->successWithDataResponse(NotificationResource::collection($notifications));
    }

    public function markNotificationAsRead(Request $request, $id)
    {
        $user = $request->user();
        
        $notification = $user->notifications()->find($id);
        
        if (!$notification) {
            return $this->failureResponse(__('messages.notification_not_found'));
        }

        $notification->markAsRead();
        
        return $this->successResponse(__('messages.notification_marked_as_read'));
    }

    public function markAllNotificationsAsRead(Request $request)
    {
        $user = $request->user();
        
        $user->unreadNotifications->markAsRead();
        
        return $this->successResponse(__('messages.all_notifications_marked_as_read'));
    }

    private function buildUserCoursesQuery($user, $subjectId = null)
    {
        if ($user->isUniversityStudent()) {
            $collegeTypeId = $user->college?->college_type_id;

            return Course::whereHas('subject', function ($q) use ($user, $collegeTypeId, $subjectId) {
                $q->where('academic_level', AcademicLevel::UNIVERSITY)
                    ->when($collegeTypeId, fn($q2) => $q2->where('college_type_id', $collegeTypeId))
                    ->when($user->grade_id, fn($q2) => $q2->where('grade_level', $user->grade?->level))
                    ->when($subjectId, fn($q2) => $q2->where('id', $subjectId));
            });
        }

        return Course::whereHas('subject', function ($q) use ($user, $subjectId) {
            $q->where('academic_level', AcademicLevel::SECONDARY)
                ->where('secondary_type', $user->secondary_type)
                ->where('secondary_grade', $user->secondary_grade)
                ->when($user->secondary_section, fn($q2) => $q2->where('secondary_section', $user->secondary_section))
                ->when($subjectId, fn($q2) => $q2->where('id', $subjectId));
        });
    }
}
