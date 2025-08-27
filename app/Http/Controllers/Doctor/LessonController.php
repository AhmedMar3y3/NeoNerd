<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Lesson\StoreLessonRequest;
use App\Http\Requests\Doctor\Lesson\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function index(Request $request, $courseId, $unitId)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit   = Unit::where('course_id', $courseId)->findOrFail($unitId);
        $query  = Lesson::with(['unit'])
            ->where('unit_id', $unitId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
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

        if ($request->filled('has_file')) {
            $hasFile = $request->has_file === 'yes';
            $query->where('has_file', $hasFile);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSortFields = ['title', 'duration', 'created_at', 'is_free'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $lessons    = $query->paginate(15);
        $statistics = $this->getStatistics($unitId);

        return view('Doctor.units.show', compact('lessons', 'unit', 'course', 'statistics'));
    }

    public function create($courseId, $unitId)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit   = Unit::where('course_id', $courseId)->findOrFail($unitId);
        return view('Doctor.lessons.create', compact('unit', 'course'));
    }

    public function store(StoreLessonRequest $request, $courseId, $unitId)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        Unit::where('course_id', $courseId)->findOrFail($unitId);
        Lesson::create($request->validated() + ['unit_id' => $unitId]);
        return redirect()->route('doctor.courses.units.lessons.index', [$courseId, $unitId])->with('success', 'تم إنشاء الدرس بنجاح');
    }

    public function show($courseId, $unitId, $id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit   = Unit::where('course_id', $courseId)->findOrFail($unitId);
        $lesson = Lesson::with(['unit'])->where('unit_id', $unitId)->findOrFail($id);
        return view('Doctor.lessons.show', compact('lesson', 'unit', 'course'));
    }

    public function edit($courseId, $unitId, $id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit   = Unit::where('course_id', $courseId)->findOrFail($unitId);
        $lesson = Lesson::where('unit_id', $unitId)->findOrFail($id);
        return view('Doctor.lessons.edit', compact('lesson', 'unit', 'course'));
    }

    public function update(UpdateLessonRequest $request, $courseId, $unitId, $id)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        Unit::where('course_id', $courseId)->findOrFail($unitId);
        $lesson = Lesson::where('unit_id', $unitId)->findOrFail($id);
        $lesson->update($request->validated() + ['unit_id' => $unitId]);
        return redirect()->route('doctor.courses.units.lessons.index', [$courseId, $unitId])->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy($courseId, $unitId, $id)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        Unit::where('course_id', $courseId)->findOrFail($unitId);
        $lesson = Lesson::where('unit_id', $unitId)->findOrFail($id);
        $lesson->delete();
        return redirect()->route('doctor.courses.units.lessons.index', [$courseId, $unitId])->with('success', 'تم حذف الدرس بنجاح');
    }

    private function getStatistics($unitId)
    {
        $totalLessons     = Lesson::where('unit_id', $unitId)->count();
        $freeLessons      = Lesson::where('unit_id', $unitId)->where('is_free', true)->count();
        $paidLessons      = Lesson::where('unit_id', $unitId)->where('is_free', false)->count();
        $lessonsWithFiles = Lesson::where('unit_id', $unitId)->where('has_file', true)->count();

        $totalDuration = Lesson::where('unit_id', $unitId)
            ->get()
            ->sum(function ($lesson) {
                return $this->parseDuration($lesson->duration);
            });

        return [
            'total_lessons'      => $totalLessons,
            'free_lessons'       => $freeLessons,
            'paid_lessons'       => $paidLessons,
            'lessons_with_files' => $lessonsWithFiles,
            'total_duration'     => $this->formatDuration($totalDuration),
        ];
    }

    private function parseDuration($duration)
    {
        $parts = explode(':', $duration);
        return (int) $parts[0] * 60 + (int) $parts[1];
    }

    private function formatDuration($minutes)
    {
        $hours = floor($minutes / 60);
        $mins  = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }
}
