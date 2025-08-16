<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Filters\SubjectFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subject\StoreSubjectRequest;
use App\Http\Requests\Admin\Subject\UpdateSubjectRequest;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(['collegeType']);

        $filter = new SubjectFilter();
        $filter->apply($request, $query);
        $subjects = $query->paginate(15);
        $filterOptions = $filter->getFilterOptions();
        $statistics = $filter->getStatistics();
        return view('Admin.subjects.index', compact('subjects', 'filterOptions', 'statistics'));
    }

    public function create()
    {
        $filter = new SubjectFilter();
        $filterOptions = $filter->getFilterOptions();
        return view('Admin.subjects.create', compact('filterOptions'));
    }

    public function store(StoreSubjectRequest $request)
    {
        $validated = $request->validated();
        Subject::create($validated);
        return redirect()->route('admin.subjects.index')->with('success', 'تم إضافة المادة بنجاح');
    }

    public function show($id)
    {
        $subject = Subject::with(['collegeType'])->findOrFail($id);
        return response()->json($subject);
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $filter = new SubjectFilter();
        $filterOptions = $filter->getFilterOptions();
        return view('Admin.subjects.edit', compact('subject', 'filterOptions'));
    }

    public function update(UpdateSubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $validated = $request->validated();
        $subject->update($validated);
        return redirect()->route('admin.subjects.index')->with('success', 'تم تحديث المادة بنجاح');
    }

    public function toggleStatus($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update(['is_active' => !$subject->is_active]);
        $status = $subject->is_active ? 'تفعيل' : 'إيقاف';
        return redirect()->route('admin.subjects.index')->with('success', "تم {$status} المادة بنجاح");
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('admin.subjects.index')->with('success', 'تم حذف المادة بنجاح');
    }
}
