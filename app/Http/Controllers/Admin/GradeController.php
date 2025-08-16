<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\College;
use App\Models\University;
use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\StoreGradeRequest;
use App\Http\Requests\Grade\UpdateGradeRequest;

class GradeController extends Controller
{
    public function index(University $university, College $college)
    {
        $grades = $college->grades()
            ->withCount(['users'])
            ->orderBy('level')
            ->paginate(10);

        return view('Admin.universities.colleges.grades.index', compact('university', 'college', 'grades'));
    }

    public function show(University $university, College $college, $id)
    {
        $grade = Grade::whereHas('college', function ($query) use ($university, $college) {
            $query->where('university_id', $university->id)->where('id', $college->id);
        })->findOrFail($id);
        return response()->json($grade);
    }

    public function store(StoreGradeRequest $request, University $university, College $college)
    {
        Grade::create($request->validated() + ['college_id' => $college->id]);
        return redirect()->route('admin.universities.colleges.grades.index', [$university, $college])->with('success', 'تمت إضافة المرحلة بنجاح');
    }

    public function update(UpdateGradeRequest $request, University $university, College $college, $id)
    {
        $grade = Grade::whereHas('college', function ($query) use ($university, $college) {
            $query->where('university_id', $university->id)->where('id', $college->id);
        })->findOrFail($id);

        $grade->update($request->validated());
        return redirect()->route('admin.universities.colleges.grades.index', [$university, $college])->with('success', 'تم تعديل المرحلة بنجاح');
    }

    public function destroy(University $university, College $college, $id)
    {
        $grade = Grade::whereHas('college', function ($query) use ($university, $college) {
            $query->where('university_id', $university->id)->where('id', $college->id);
        })->findOrFail($id);

        if ($grade->users()->count() > 0) {
            return redirect()->route('admin.universities.colleges.grades.index', [$university, $college])->with('error', 'لا يمكن حذف المرحلة لوجود طلاب مرتبطين بها');
        }

        $grade->delete();
        return redirect()->route('admin.universities.colleges.grades.index', [$university, $college])->with('success', 'تم حذف المرحلة بنجاح');
    }
}
