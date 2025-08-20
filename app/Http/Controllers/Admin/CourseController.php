<?php
namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Filters\CourseFilter;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $filter        = new CourseFilter();
        $courses       = $filter->apply($request);
        $filterOptions = $filter->getFilterOptions();
        $statistics    = $filter->getStatistics();
        return view('Admin.courses.index', compact('courses', 'filterOptions', 'statistics'));
    }

    public function show($id)
    {
        $course = Course::with(['doctor', 'subject', 'units.lessons'])->findOrFail($id);
        return view('Admin.courses.show', compact('course'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'تم حذف الدورة بنجاح');
    }

    public function toggleStatus($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['is_active' => ! $course->is_active]);
        $status = $course->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->route('admin.courses.index')->with('success', "تم {$status} الدورة بنجاح");
    }
}
