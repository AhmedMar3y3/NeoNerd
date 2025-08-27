<?php

namespace App\Http\Controllers\Assistant;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Enums\SubscriptionType;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assistant\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Assistant\Subscription\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        $query = Subscription::with(['user', 'course'])
            ->whereHas('course', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('subscription_type')) {
            $query->where('subscription_type', $request->subscription_type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('recent')) {
            $days = (int) $request->recent;
            $query->where('created_at', '>=', now()->subDays($days));
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $subscriptions = $query->paginate(15);

        $filterOptions = $this->getAssistantFilterOptions($doctor);

        return view('Assistant.subscriptions.index', compact('subscriptions', 'filterOptions'));
    }

    public function create()
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        $users = User::orderBy('first_name')->get();
        $courses = $doctor->courses()->where('is_active', true)->orderBy('title')->get();
        $subscriptionTypes = [
            ['value' => SubscriptionType::COURSE, 'label' => 'دورة']
        ];

        return view('Assistant.subscriptions.create', compact('users', 'courses', 'subscriptionTypes'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        $course = $doctor->courses()->findOrFail($request->course_id);
        
        $subscription = Subscription::create($request->validated() + [
            'subscription_type' => SubscriptionType::COURSE
        ]);

        return redirect()->route('assistant.subscriptions.index')
            ->with('success', 'تم إنشاء الاشتراك بنجاح');
    }

    public function show(Subscription $subscription)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($subscription->course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الاشتراك');
        }

        return view('Assistant.subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($subscription->course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الاشتراك');
        }

        $users = User::orderBy('first_name')->get();
        $courses = $doctor->courses()->where('is_active', true)->orderBy('title')->get();
        $subscriptionTypes = [
            ['value' => SubscriptionType::COURSE, 'label' => 'دورة']
        ];

        return view('Assistant.subscriptions.edit', compact('subscription', 'users', 'courses', 'subscriptionTypes'));
    }

    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($subscription->course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الاشتراك');
        }

        if ($request->course_id) {
            $course = $doctor->courses()->findOrFail($request->course_id);
        }

        $subscription->update($request->validated());

        return redirect()->route('assistant.subscriptions.index')
            ->with('success', 'تم تحديث الاشتراك بنجاح');
    }

    public function destroy(Subscription $subscription)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($subscription->course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الاشتراك');
        }

        $subscription->delete();

        return redirect()->route('assistant.subscriptions.index')
            ->with('success', 'تم حذف الاشتراك بنجاح');
    }

    public function toggleStatus(Subscription $subscription)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($subscription->course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذا الاشتراك');
        }

        $subscription->update(['is_active' => !$subscription->is_active]);

        $status = $subscription->is_active ? 'تفعيل' : 'إلغاء التفعيل';
        return redirect()->route('assistant.subscriptions.index')
            ->with('success', "تم {$status} الاشتراك بنجاح");
    }

    public function bulkAction(Request $request)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'subscription_ids' => 'required|array',
            'subscription_ids.*' => 'exists:subscriptions,id'
        ]);

        $subscriptions = Subscription::whereIn('id', $request->subscription_ids)
            ->whereHas('course', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })->get();

        if ($subscriptions->count() !== count($request->subscription_ids)) {
            abort(403, 'بعض الاشتراكات غير مصرح لك بالوصول إليها');
        }

        switch ($request->action) {
            case 'activate':
                $subscriptions->each(function ($subscription) {
                    $subscription->update(['is_active' => true]);
                });
                $message = 'تم تفعيل الاشتراكات المحددة بنجاح';
                break;
                
            case 'deactivate':
                $subscriptions->each(function ($subscription) {
                    $subscription->update(['is_active' => false]);
                });
                $message = 'تم إلغاء تفعيل الاشتراكات المحددة بنجاح';
                break;
                
            case 'delete':
                $subscriptions->each(function ($subscription) {
                    $subscription->delete();
                });
                $message = 'تم حذف الاشتراكات المحددة بنجاح';
                break;
        }

        return redirect()->route('assistant.subscriptions.index')->with('success', $message);
    }

    public function getUserSubscriptions(User $user)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        $subscriptions = Subscription::with(['course'])
            ->where('user_id', $user->id)
            ->whereHas('course', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })->paginate(15);
        return view('Assistant.subscriptions.user-subscriptions', compact('subscriptions', 'user'));
    }

    public function getContentSubscriptions(Course $course)
    {
        $assistant = Auth::guard('assistant')->user();
        $doctor = $assistant->doctor;
        
        if ($course->doctor_id !== $doctor->id) {
            abort(403, 'غير مصرح لك بالوصول إلى هذه الدورة');
        }

        $subscriptions = Subscription::with(['user'])->where('course_id', $course->id)->paginate(15);
        return view('Assistant.subscriptions.content-subscriptions', compact('subscriptions', 'course'));
    }

    private function getAssistantFilterOptions($doctor)
    {
        return [
            'subscription_types' => [
                ['value' => SubscriptionType::COURSE, 'label' => 'دورة']
            ],
            'users' => User::whereHas('subscriptions.course', function ($q) use ($doctor) {
                $q->where('doctor_id', $doctor->id);
            })->distinct()->orderBy('first_name')->get(),
            'courses' => $doctor->courses()->orderBy('title')->get(),
        ];
    }
}
