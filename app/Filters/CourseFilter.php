<?php
namespace App\Filters;

use App\Models\Course;
use App\Models\Doctor;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseFilter
{
    public function apply(Request $request)
    {
        $query = Course::with(['doctor', 'subject', 'units.lessons']);

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        // Filter by price type
        if ($request->filled('price_type')) {
            switch ($request->price_type) {
                case 'free':
                    $query->where('is_free', true);
                    break;
                case 'paid':
                    $query->where('is_free', false);
                    break;
            }
        }

        // Filter by doctor
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        // Filter by subject
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['title', 'rating', 'price', 'created_at', 'is_active'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate(15);
    }

    public function getFilterOptions()
    {
        return [
            'doctors'  => Doctor::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ];
    }

    public function getStatistics()
    {
        $totalCourses    = Course::count();
        $activeCourses   = Course::where('is_active', true)->count();
        $inactiveCourses = Course::where('is_active', false)->count();
        $freeCourses     = Course::where('is_free', true)->count();
        $paidCourses     = Course::where('is_free', false)->count();
        $totalUnits      = Course::withCount('units')->get()->sum('units_count');
        $totalLessons    = Course::withCount('lessons')->get()->sum('lessons_count');

        return [
            'total'         => $totalCourses,
            'active'        => $activeCourses,
            'inactive'      => $inactiveCourses,
            'free'          => $freeCourses,
            'paid'          => $paidCourses,
            'total_units'   => $totalUnits,
            'total_lessons' => $totalLessons,
        ];
    }
}
