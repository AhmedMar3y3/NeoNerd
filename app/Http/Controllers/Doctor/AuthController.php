<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Doctor;
use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Auth\LoginDoctorRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loadLoginPage()
    {
        return view('Doctor.login');
    }

    public function loginUser(LoginDoctorRequest $request)
    {
        $credentials = $request->validated();
        $doctor = Doctor::where('email', $credentials['email'])->first();
        if (!$doctor->is_active) {
            return back()->withErrors(['error' => 'حسابك غير مفعل. يرجى التواصل مع الإدارة.'])->withInput();
        }
        if (Auth::guard('doctor')->attempt($credentials)) {
            return redirect()->route('doctor.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('doctorloginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();
        
        $hour = now()->hour;
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'صباح الخير';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'مساء الخير';
        } else {
            $greeting = 'مساء الخير';
        }
        
        $totalCourses = $doctor->courses()->count();
        $totalAssistants = $doctor->assistants()->where('is_active', true)->count();
        
        $courses = $doctor->courses()->with(['units', 'lessons', 'subscriptions'])->get();
        $totalUnits = $courses->sum(function($course) {
            return $course->units->count();
        });
        $totalLessons = $courses->sum(function($course) {
            return $course->lessons->count();
        });
        $totalSubscriptions = $courses->sum(function($course) {
            return $course->subscriptions->count();
        });
        
        $totalStudents = $courses->flatMap(function ($course) {
            return $course->subscriptions->pluck('user');
        })->unique('id')->count();
        
        $totalRevenue = $courses->sum(function ($course) {
            return $course->subscriptions->count() * ($course->price ?? 0);
        });
        
        return view('Doctor.dashboard', compact(
            'greeting',
            'totalCourses',
            'totalUnits', 
            'totalLessons',
            'totalSubscriptions',
            'totalAssistants',
            'totalStudents',
            'totalRevenue'
        ));
    }
}
