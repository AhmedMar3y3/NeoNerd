<?php

namespace App\Http\Controllers\User;

use App\Enums\AcademicLevel;
use App\Enums\Term;
use App\Models\Banner;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Subscription;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\Course\CourseDetailsResource;
use App\Http\Resources\Home\SubjectsResource;

class HomeController extends Controller
{
    use HttpResponses;

    
    public function banners()
    {
        return $this->successWithDataResponse(Banner::get(['id','title','image']));
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
                'doctor'
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->findOrFail($id);
        } else {
            $course = Course::with([
                'units.lessons',
                'doctor'
            ])
            ->withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->findOrFail($id);
        }

        return $this->successWithDataResponse(new CourseDetailsResource($course, $isSubscribed));
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
