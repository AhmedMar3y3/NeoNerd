<?php
namespace App\Http\Controllers\Doctor;

use App\Models\Unit;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Doctor\Unit\StoreUnitRequest;
use App\Http\Requests\Doctor\Unit\UpdateUnitRequest;

class UnitController extends Controller
{
    public function index(Request $request, $courseId)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())
            ->findOrFail($courseId);

        $query = Unit::with(['course', 'lessons'])
            ->where('course_id', $courseId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSortFields = ['title', 'created_at'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'asc');
        }

        $units      = $query->paginate(15);
        $statistics = $this->getStatistics($courseId);

        return view('Doctor.units.index', compact('units', 'course', 'statistics'));
    }

    public function create($courseId)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        return view('Doctor.units.create', compact('course'));
    }

    public function store(StoreUnitRequest $request, $courseId)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        Unit::create($request->validated() + ['course_id' => $courseId]);
        return redirect()->route('doctor.courses.units.index', $courseId)->with('success', 'تم إنشاء الوحدة بنجاح');
    }

    public function show($courseId, $id)
    {
        $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit   = Unit::with(['course', 'lessons'])->where('course_id', $courseId)->findOrFail($id);
        return view('Doctor.units.show', compact('unit', 'course'));
    }

    // public function edit($courseId, $id)
    // {
    //     $course = Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
    //     $unit   = Unit::where('course_id', $courseId)->findOrFail($id);
    //     return view('Doctor.units.edit', compact('unit', 'course'));
    // }

    public function update(UpdateUnitRequest $request, $courseId, $id)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit = Unit::where('course_id', $courseId)->findOrFail($id);
        $unit->update($request->validated());
        return redirect()->route('doctor.courses.units.index', $courseId)->with('success', 'تم تحديث الوحدة بنجاح');
    }

    public function destroy($courseId, $id)
    {
        Course::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($courseId);
        $unit = Unit::where('course_id', $courseId)->findOrFail($id);
        $unit->delete();

        return redirect()->route('doctor.courses.units.index', $courseId)->with('success', 'تم حذف الوحدة بنجاح');
    }

    private function getStatistics($courseId)
    {
        $totalUnits   = Unit::where('course_id', $courseId)->count();
        $totalLessons = Unit::where('course_id', $courseId)
            ->withCount('lessons')
            ->get()
            ->sum('lessons_count');
        $freeLessons = Unit::where('course_id', $courseId)
            ->withCount(['lessons' => function ($query) {
                $query->where('is_free', true);
            }])
            ->get()
            ->sum('lessons_count');

        return [
            'total_units'   => $totalUnits,
            'total_lessons' => $totalLessons,
            'free_lessons'  => $freeLessons,
        ];
    }
}
