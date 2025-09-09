<?php
namespace App\Http\Controllers\Doctor;

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Filters\CourseFilter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Doctor\Course\StoreCourseRequest;
use App\Http\Requests\Doctor\Course\UpdateCourseRequest;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $filter = new CourseFilter();
        $query  = Course::with(['doctor', 'subject', 'units.lessons'])
            ->where('doctor_id', Auth::guard('doctor')->id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

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

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['title', 'rating', 'price', 'created_at', 'is_active'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(15);

        $filterOptions = [
            'subjects' => Subject::with('collegeType')
                ->orderBy('academic_level')
                ->orderBy('grade_level')
                ->orderBy('secondary_grade')
                ->orderBy('name')
                ->get(),
        ];

        $statistics = $this->getStatistics();

        return view('Doctor.courses.index', compact('courses', 'filterOptions', 'statistics'));
    }

    public function create()
    {
        $doctor = Auth::guard('doctor')->user();
        if ($doctor->is_profile_completed == false) {
            return redirect()->route('doctor.courses.index')->with('error', 'يرجى تحديث معلوماتك الدراسية قبل إنشاء دورة.');
        }
        $subjects = Subject::with('collegeType')
            ->orderBy('academic_level')
            ->orderBy('grade_level')
            ->orderBy('secondary_grade')
            ->orderBy('name')
            ->get();
        return view('Doctor.courses.create', compact('subjects'));
    }

    public function store(StoreCourseRequest $request)
    {
        Course::create($request->validated() + ['doctor_id' => Auth::guard('doctor')->id()]);
        return redirect()->route('doctor.courses.index')->with('success', 'تم إنشاء الدورة بنجاح');
    }

    public function show($id)
    {
        $course = Course::with(['doctor', 'subject', 'units.lessons'])
            ->where('doctor_id', Auth::guard('doctor')->id())
            ->findOrFail($id);

        return view('Doctor.courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course   = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($id);
        $subjects = Subject::with('collegeType')
            ->orderBy('academic_level')
            ->orderBy('grade_level')
            ->orderBy('secondary_grade')
            ->orderBy('name')
            ->get();
        return view('Doctor.courses.edit', compact('course', 'subjects'));
    }

    public function update(UpdateCourseRequest $request, $id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($id);
        $course->update($request->validated());
        return redirect()->route('doctor.courses.index')->with('success', 'تم تحديث الدورة بنجاح');
    }

    public function destroy($id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())
            ->findOrFail($id);

        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();
        return redirect()->route('doctor.courses.index')->with('success', 'تم حذف الدورة بنجاح');
    }

    public function toggleStatus($id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($id);
        $course->update(['is_active' => ! $course->is_active]);
        $status = $course->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->route('doctor.courses.index')->with('success', "تم {$status} الدورة بنجاح");
    }

    private function getStatistics()
    {
        $doctorId = Auth::guard('doctor')->id();

        $totalCourses    = Course::where('doctor_id', $doctorId)->count();
        $activeCourses   = Course::where('doctor_id', $doctorId)->where('is_active', true)->count();
        $inactiveCourses = Course::where('doctor_id', $doctorId)->where('is_active', false)->count();
        $freeCourses     = Course::where('doctor_id', $doctorId)->where('is_free', true)->count();
        $paidCourses     = Course::where('doctor_id', $doctorId)->where('is_free', false)->count();

        $totalUnits = Course::where('doctor_id', $doctorId)
            ->withCount('units')
            ->get()
            ->sum('units_count');

        $totalLessons = Course::where('doctor_id', $doctorId)
            ->withCount('lessons')
            ->get()
            ->sum('lessons_count');

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
