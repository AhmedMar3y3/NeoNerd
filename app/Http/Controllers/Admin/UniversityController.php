<?php

namespace App\Http\Controllers\Admin;

use App\Models\University;
use App\Http\Controllers\Controller;
use App\Http\Requests\University\StoreUniversityRequest;
use App\Http\Requests\University\UpdateUniversityRequest;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::withCount('colleges')->orderBy('name')->paginate(10);
        return view('Admin.universities.index', compact('universities'));
    }

    public function show($id)
    {
        $university = University::findOrFail($id);
        return response()->json($university);
    }

    public function store(StoreUniversityRequest $request)
    {
        University::create($request->validated());
        return redirect()->route('admin.universities.index')->with('success', 'تمت إضافة الجامعة بنجاح');
    }

    public function update(UpdateUniversityRequest $request, $id)
    {
        University::findOrFail($id)->update($request->validated());
        return redirect()->route('admin.universities.index')->with('success', 'تم تعديل الجامعة بنجاح');
    }

    public function destroy($id)
    {
        $university = University::findOrFail($id);

        if ($university->colleges()->count() > 0) {
            return redirect()->route('admin.universities.index')->with('error', 'لا يمكن حذف الجامعة لوجود كليات مرتبطة بها');
        }

        $university->delete();
        return redirect()->route('admin.universities.index')->with('success', 'تم حذف الجامعة بنجاح');
    }
}
