<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\LoginAdminRequest;

class AuthController extends Controller
{
    public function loadLoginPage()
    {
        return view('Admin.login');
    }

    public function loginUser(LoginAdminRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return back()->withErrors(['error' => 'خطأ في كلمة المرور او المستخدم'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        
        $hour = now()->hour;
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'صباح الخير';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'مساء الخير';
        } else {
            $greeting = 'مساء الخير';
        }
        
        $totalUsers = \App\Models\User::count();
        $totalDoctors = \App\Models\Doctor::count();
        $totalCourses = \App\Models\Course::count();
        $totalSubscriptions = \App\Models\Subscription::count();
        $totalSubjects = \App\Models\Subject::count();
        $totalUniversities = \App\Models\University::count();
        
        $activeUsers = \App\Models\User::where('is_active', true)->count();
        $activeDoctors = \App\Models\Doctor::where('is_active', true)->count();
        $activeCourses = \App\Models\Course::where('is_active', true)->count();
        $activeSubscriptions = \App\Models\Subscription::where('is_active', true)->count();
        
        $recentUsers = \App\Models\User::where('created_at', '>=', now()->subDays(7))->count();
        $recentCourses = \App\Models\Course::where('created_at', '>=', now()->subDays(7))->count();
        $recentSubscriptions = \App\Models\Subscription::where('created_at', '>=', now()->subDays(7))->count();
        
        $totalRevenue = \App\Models\Course::with('subscriptions')
            ->get()
            ->sum(function($course) {
                return $course->subscriptions->count() * ($course->price ?? 0);
            });
        
        $last7DaysUsers = \App\Models\User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');
        
        return view('Admin.dashboard', compact(
            'admin',
            'greeting',
            'totalUsers',
            'totalDoctors', 
            'totalCourses',
            'totalSubscriptions',
            'totalSubjects',
            'totalUniversities',
            'activeUsers',
            'activeDoctors',
            'activeCourses',
            'activeSubscriptions',
            'recentUsers',
            'recentCourses',
            'recentSubscriptions',
            'totalRevenue',
            'last7DaysUsers'
        ));
    }
}
