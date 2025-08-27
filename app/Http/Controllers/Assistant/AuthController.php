<?php

namespace App\Http\Controllers\Assistant;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Assistant\Auth\LoginAssistantRequest;

class AuthController extends Controller
{
     public function loadLoginPage()
    {
        return view('Assistant.login');
    }

    public function loginUser(LoginAssistantRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('assistant')->attempt($credentials)) {
            return redirect()->route('assistant.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('assistantloginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function dashboard()
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;

        $hour = Carbon::now()->hour;
        if ($hour < 12) {
            $greeting = 'صباح الخير';
        } elseif ($hour < 18) {
            $greeting = 'مساء الخير';
        } else {
            $greeting = 'مساء الخير';
        }

        $statistics = [
            'total_courses' => $doctor->courses()->count(),
            'total_units' => $doctor->courses()->withCount('units')->get()->sum('units_count'),
            'total_lessons' => $doctor->courses()->withCount('lessons')->get()->sum('lessons_count'),
            'total_subscriptions' => $doctor->courses()->withCount('subscriptions')->get()->sum('subscriptions_count'),
        ];

        return view('Assistant.dashboard', compact('greeting', 'statistics', 'assistant'));
    }
}
