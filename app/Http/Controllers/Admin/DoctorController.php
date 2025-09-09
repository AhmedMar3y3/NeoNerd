<?php
namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Filters\DoctorFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Doctor\StoreDoctorRequest;
use App\Http\Requests\Admin\Doctor\UpdateDoctorRequest;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $filter        = new DoctorFilter();
        $doctors       = $filter->apply($request);
        $filterOptions = $filter->getFilterOptions();
        $statistics    = $filter->getStatistics();

        return view('Admin.doctors.index', compact('doctors', 'filterOptions', 'statistics'));
    }

    public function create()
    {
        return view('Admin.doctors.create');
    }

    public function store(StoreDoctorRequest $request)
    {
        Doctor::create($request->validated());
        return redirect()->route('admin.doctors.index')->with('success', 'تم إضافة الطبيب بنجاح');
    }

    public function show($id)
    {
        $doctor = Doctor::with(['university'])->findOrFail($id);
        return view('Admin.doctors.show', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('Admin.doctors.edit', compact('doctor'));
    }

    public function update(UpdateDoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $data   = $request->validated();
        if (empty($data['password'])) {unset($data['password']);}
        $doctor->update($data);
        return redirect()->route('admin.doctors.index')->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'تم حذف الطبيب بنجاح');
    }

    public function toggleStatus($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update(['is_active' => ! $doctor->is_active]);
        $status = $doctor->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        return redirect()->route('admin.doctors.index')->with('success', "تم {$status} الطبيب بنجاح");
    }
}
