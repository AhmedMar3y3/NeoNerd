<?php

namespace App\Http\Controllers\Admin;

use App\Models\College;
use App\Models\University;
use App\Http\Controllers\Controller;
use App\Http\Requests\College\StoreCollegeRequest;
use App\Http\Requests\College\UpdateCollegeRequest;

class CollegeController extends Controller
{
    public function index(University $university)
    {
        $colleges = $university->colleges()
            ->withCount(['grades', 'users'])
            ->with(['collegeType'])
            ->orderBy('name')
            ->paginate(10);

        return view('Admin.universities.colleges.index', compact('university', 'colleges'));
    }

    public function show(University $university, $id)
    {
        $college = College::where('university_id', $university->id)->findOrFail($id);
        return response()->json($college);
    }

    public function store(StoreCollegeRequest $request, University $university)
    {
        College::create($request->validated() + ['university_id' => $university->id]);
        return redirect()->route('admin.universities.colleges.index', $university)->with('success', 'تمت إضافة الكلية بنجاح');
    }

    public function update(UpdateCollegeRequest $request, University $university, $id)
    {
        $college = College::where('university_id', $university->id)->findOrFail($id);
        $college->update($request->validated());
        return redirect()->route('admin.universities.colleges.index', $university)->with('success', 'تم تعديل الكلية بنجاح');
    }

    public function destroy(University $university, $id)
    {
        $college = College::where('university_id', $university->id)->findOrFail($id);

        if ($college->grades()->count() > 0) {
            return redirect()->route('admin.universities.colleges.index', $university)->with('error', 'لا يمكن حذف الكلية لوجود مراحل مرتبطة بها');
        }

        $college->delete();
        return redirect()->route('admin.universities.colleges.index', $university)->with('success', 'تم حذف الكلية بنجاح');
    }
}
