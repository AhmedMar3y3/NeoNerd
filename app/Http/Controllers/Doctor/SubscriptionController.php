<?php
namespace App\Http\Controllers\Doctor;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Enums\SubscriptionType;
use Illuminate\Support\Facades\DB;
use App\Filters\SubscriptionFilter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Doctor\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Doctor\Subscription\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $filter = new SubscriptionFilter();
        
        $subscriptions = $this->getDoctorSubscriptions($request);
        $filterOptions = $this->getDoctorFilterOptions();
        $statistics = $this->getDoctorStatistics();

        return view('Doctor.subscriptions.index', compact('subscriptions', 'filterOptions', 'statistics'));
    }

    public function create()
    {
        $users = User::orderBy('first_name')->get();
        $courses = Course::where('doctor_id', Auth::guard('doctor')->id())
                        ->where('is_active', true)
                        ->orderBy('title')
                        ->get();
        $subscriptionTypes = SubscriptionType::cases();

        return view('Doctor.subscriptions.create', compact('users', 'courses', 'subscriptionTypes'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->subscription_type === SubscriptionType::COURSE->value) {
                $course = Course::where('id', $request->course_id)
                               ->where('doctor_id', Auth::guard('doctor')->id())
                               ->first();
                
                if (!$course) {
                    return back()->withErrors(['course_id' => 'الدورة غير موجودة أو لا تملك صلاحية الوصول إليها'])->withInput();
                }
            }

            $existingSubscription = Subscription::where('user_id', $request->user_id)
                ->where('is_active', true)
                ->where(function ($query) use ($request) {
                    if ($request->subscription_type === SubscriptionType::COURSE->value) {
                        $query->where('course_id', $request->course_id);
                    } else {
                        $query->where('book_id', $request->book_id);
                    }
                })
                ->first();

            if ($existingSubscription) {
                $contentType = $request->subscription_type === SubscriptionType::COURSE->value ? 'هذه الدورة' : 'هذا الكتاب';
                return back()->withErrors(['subscription' => "المستخدم لديه اشتراك نشط بالفعل في {$contentType}"])->withInput();
            }

            Subscription::create($request->validated());

            DB::commit();

            return redirect()->route('doctor.subscriptions.index')
                ->with('success', 'تم إنشاء الاشتراك بنجاح');

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الاشتراك'])->withInput();
        }
    }

    public function show($id)
    {
        $subscription = Subscription::with(['user', 'course', 'book'])
                                   ->whereHas('course', function ($query) {
                                       $query->where('doctor_id', Auth::guard('doctor')->id());
                                   })
                                   ->findOrFail($id);
        
        return view('Doctor.subscriptions.show', compact('subscription'));
    }

    public function edit($id)
    {
        $subscription = Subscription::whereHas('course', function ($query) {
                                    $query->where('doctor_id', Auth::guard('doctor')->id());
                                })
                                ->findOrFail($id);
        
        $users = User::orderBy('first_name')->get();
        $courses = Course::where('doctor_id', Auth::guard('doctor')->id())
                        ->where('is_active', true)
                        ->orderBy('title')
                        ->get();
        $subscriptionTypes = SubscriptionType::cases();

        return view('Doctor.subscriptions.edit', compact('subscription', 'users', 'courses', 'subscriptionTypes'));
    }

    public function update(UpdateSubscriptionRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $subscription = Subscription::whereHas('course', function ($query) {
                                    $query->where('doctor_id', Auth::guard('doctor')->id());
                                })
                                ->findOrFail($id);

            if ($request->subscription_type === SubscriptionType::COURSE->value) {
                $course = Course::where('id', $request->course_id)
                               ->where('doctor_id', Auth::guard('doctor')->id())
                               ->first();
                
                if (!$course) {
                    return back()->withErrors(['course_id' => 'الدورة غير موجودة أو لا تملك صلاحية الوصول إليها'])->withInput();
                }
            }

            if ($request->subscription_type === SubscriptionType::COURSE->value && $request->course_id) {
                $existingSubscription = Subscription::where('user_id', $request->user_id)
                    ->where('course_id', $request->course_id)
                    ->where('is_active', true)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingSubscription) {
                    return back()->withErrors(['subscription' => 'المستخدم لديه اشتراك نشط بالفعل في هذه الدورة'])->withInput();
                }
            }

            $subscription->update($request->validated());

            DB::commit();

            return redirect()->route('doctor.subscriptions.index')
                ->with('success', 'تم تحديث الاشتراك بنجاح');

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث الاشتراك'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $subscription = Subscription::whereHas('course', function ($query) {
                                    $query->where('doctor_id', Auth::guard('doctor')->id());
                                })
                                ->findOrFail($id);
            
            $subscription->delete();

            return redirect()->route('doctor.subscriptions.index')
                ->with('success', 'تم حذف الاشتراك بنجاح');

        } catch (\Exception) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء حذف الاشتراك']);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $subscription = Subscription::whereHas('course', function ($query) {
                                    $query->where('doctor_id', Auth::guard('doctor')->id());
                                })
                                ->findOrFail($id);
            
            $subscription->update(['is_active' => ! $subscription->is_active]);

            $status = $subscription->is_active ? 'تفعيل' : 'إلغاء تفعيل';
            return redirect()->route('doctor.subscriptions.index')
                ->with('success', "تم {$status} الاشتراك بنجاح");

        } catch (\Exception) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء تغيير حالة الاشتراك']);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action'             => 'required|in:activate,deactivate,delete',
            'subscription_ids'   => 'required|array',
            'subscription_ids.*' => 'exists:subscriptions,id',
        ]);

        try {
            DB::beginTransaction();

            $subscriptions = Subscription::whereIn('id', $request->subscription_ids)
                                        ->whereHas('course', function ($query) {
                                            $query->where('doctor_id', Auth::guard('doctor')->id());
                                        });

            switch ($request->action) {
                case 'activate':
                    $subscriptions->update(['is_active' => true]);
                    $message = 'تم تفعيل الاشتراكات المحددة بنجاح';
                    break;
                case 'deactivate':
                    $subscriptions->update(['is_active' => false]);
                    $message = 'تم إلغاء تفعيل الاشتراكات المحددة بنجاح';
                    break;
                case 'delete':
                    $subscriptions->delete();
                    $message = 'تم حذف الاشتراكات المحددة بنجاح';
                    break;
            }

            DB::commit();

            return redirect()->route('doctor.subscriptions.index')
                ->with('success', $message);

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء تنفيذ العملية']);
        }
    }

    public function getUserSubscriptions($userId)
    {
        $user = User::with(['subscriptions' => function ($query) {
                        $query->whereHas('course', function ($q) {
                            $q->where('doctor_id', Auth::guard('doctor')->id());
                        });
                    }, 'subscriptions.course'])
                    ->findOrFail($userId);
        
        return view('Doctor.subscriptions.user-subscriptions', compact('user'));
    }

    public function getContentSubscriptions($type, $contentId)
    {
        if ($type !== 'course') {
            abort(403, 'غير مسموح بالوصول إلى اشتراكات الكتب');
        }

        $course = Course::where('id', $contentId)
                       ->where('doctor_id', Auth::guard('doctor')->id())
                       ->firstOrFail();

        $subscriptions = Subscription::with('user')
            ->where('subscription_type', $type)
            ->where($type . '_id', $contentId)
            ->paginate(15);

        return view('Doctor.subscriptions.content-subscriptions', compact('subscriptions', 'course', 'type'));
    }

    private function getDoctorSubscriptions(Request $request)
    {
        $query = Subscription::with(['user', 'course', 'book'])
                            ->whereHas('course', function ($q) {
                                $q->where('doctor_id', Auth::guard('doctor')->id());
                            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('subscription_type')) {
            $query->where('subscription_type', $request->subscription_type);
        }

        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
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
            switch ($request->recent) {
                case '7':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case '90':
                    $query->where('created_at', '>=', now()->subDays(90));
                    break;
            }
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['created_at', 'is_active', 'subscription_type'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate(15);
    }

    private function getDoctorFilterOptions()
    {
        return [
            'users' => User::orderBy('first_name')->get(),
            'courses' => Course::where('doctor_id', Auth::guard('doctor')->id())
                              ->where('is_active', true)
                              ->orderBy('title')
                              ->get(),
            'subscription_types' => [
                ['value' => SubscriptionType::COURSE->value, 'label' => 'دورة'],
            ],
        ];
    }

    private function getDoctorStatistics()
    {
        $doctorId = Auth::guard('doctor')->id();
        
        $totalSubscriptions = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->count();

        $activeSubscriptions = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->where('is_active', true)->count();

        $inactiveSubscriptions = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->where('is_active', false)->count();

        $courseSubscriptions = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->where('subscription_type', SubscriptionType::COURSE->value)->count();

        $activeCourseSubscriptions = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->where('subscription_type', SubscriptionType::COURSE->value)
          ->where('is_active', true)->count();

        $uniqueUsers = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->distinct('user_id')->count();

        $uniqueActiveUsers = Subscription::whereHas('course', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })->where('is_active', true)->distinct('user_id')->count();

        return [
            'total' => $totalSubscriptions,
            'active' => $activeSubscriptions,
            'inactive' => $inactiveSubscriptions,
            'course_subscriptions' => $courseSubscriptions,
            'active_course_subscriptions' => $activeCourseSubscriptions,
            'unique_users' => $uniqueUsers,
            'unique_active_users' => $uniqueActiveUsers,
        ];
    }
}
