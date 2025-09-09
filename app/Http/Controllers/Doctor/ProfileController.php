<?php
namespace App\Http\Controllers\Doctor;

use App\Models\University;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Doctor\Profile\UpdateProfileRequest;
use App\Http\Requests\Doctor\Profile\ChangePasswordRequest;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user       = Auth::guard('doctor')->user();
        $universities = University::all();
        return view('Doctor.profile', compact('user', 'universities'));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::guard('doctor')->user();
        $user->update($request->validated() + ['is_profile_completed' => true]);
        return redirect()->route('doctor.profile.index')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user           = Auth::guard('doctor')->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('doctor.profile.index')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
