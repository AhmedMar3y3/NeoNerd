<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Assistant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Assistant\StoreAssistantRequest;
use App\Http\Requests\Doctor\Assistant\UpdateAssistantRequest;

class AssistantController extends Controller
{
    public function index()
    {
        $assistants = Assistant::where('doctor_id', Auth::guard('doctor')->id())
            ->with('doctor')
            ->latest()
            ->paginate(10);

        $statistics = $this->getStatistics();

        return view('Doctor.assistants.index', compact('assistants', 'statistics'));
    }

    public function create()
    {
        return view('Doctor.assistants.create');
    }

    public function store(StoreAssistantRequest $request)
    {
        Assistant::create($request->validated() + [
            'doctor_id' => Auth::guard('doctor')->id(),
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('doctor.assistants.index')
            ->with('success', 'تم إنشاء المساعد بنجاح');
    }



    public function edit(Assistant $assistant)
    {
        if ($assistant->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        return view('Doctor.assistants.edit', compact('assistant'));
    }

    public function update(UpdateAssistantRequest $request, Assistant $assistant)
    {
        if ($assistant->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $data = $request->validated();
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $assistant->update($data);

        return redirect()->route('doctor.assistants.index')
            ->with('success', 'تم تحديث المساعد بنجاح');
    }

    public function destroy(Assistant $assistant)
    {
        if ($assistant->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $assistant->delete();

        return redirect()->route('doctor.assistants.index')
            ->with('success', 'تم حذف المساعد بنجاح');
    }

    public function toggleStatus(Assistant $assistant)
    {
        if ($assistant->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $assistant->update(['is_active' => !$assistant->is_active]);

        return redirect()->route('doctor.assistants.index')
            ->with('success', $assistant->is_active ? 'تم تفعيل المساعد بنجاح' : 'تم إلغاء تفعيل المساعد بنجاح');
    }

    private function getStatistics()
    {
        $doctorId = Auth::guard('doctor')->id();
        
        return [
            'total' => Assistant::where('doctor_id', $doctorId)->count(),
            'active' => Assistant::where('doctor_id', $doctorId)->where('is_active', true)->count(),
            'recent' => Assistant::where('doctor_id', $doctorId)
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
        ];
    }
}
