<?php
namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Book;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Enums\SubscriptionType;
use Illuminate\Support\Facades\DB;
use App\Filters\SubscriptionFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Admin\Subscription\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $filter        = new SubscriptionFilter();
        $subscriptions = $filter->apply($request);
        $filterOptions = $filter->getFilterOptions();
        $statistics    = $filter->getStatistics();

        return view('Admin.subscriptions.index', compact('subscriptions', 'filterOptions', 'statistics'));
    }

    public function create()
    {
        $users             = User::orderBy('first_name')->get();
        $courses           = Course::where('is_active', true)->orderBy('title')->get();
        $books             = Book::where('is_active', true)->orderBy('title')->get();
        $subscriptionTypes = SubscriptionType::cases();

        return view('Admin.subscriptions.create', compact('users', 'courses', 'books', 'subscriptionTypes'));
    }

    public function store(StoreSubscriptionRequest $request)
    {
        try {
            DB::beginTransaction();

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

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'تم إنشاء الاشتراك بنجاح');

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الاشتراك'])->withInput();
        }
    }

    public function show($id)
    {
        $subscription = Subscription::with(['user', 'course', 'book'])->findOrFail($id);
        return view('Admin.subscriptions.show', compact('subscription'));
    }

    public function edit($id)
    {
        $subscription      = Subscription::findOrFail($id);
        $users             = User::orderBy('first_name')->get();
        $courses           = Course::where('is_active', true)->orderBy('title')->get();
        $books             = Book::where('is_active', true)->orderBy('title')->get();
        $subscriptionTypes = SubscriptionType::cases();

        return view('Admin.subscriptions.edit', compact('subscription', 'users', 'courses', 'books', 'subscriptionTypes'));
    }

    public function update(UpdateSubscriptionRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $subscription = Subscription::findOrFail($id);

            if ($request->subscription_type === SubscriptionType::COURSE->value && $request->course_id) {
                $existingSubscription = Subscription::where('user_id', $request->user_id)
                    ->where('course_id', $request->course_id)
                    ->where('is_active', true)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingSubscription) {
                    return back()->withErrors(['subscription' => 'المستخدم لديه اشتراك نشط بالفعل في هذه الدورة'])->withInput();
                }
            } elseif ($request->subscription_type === SubscriptionType::BOOK->value && $request->book_id) {
                $existingSubscription = Subscription::where('user_id', $request->user_id)
                    ->where('book_id', $request->book_id)
                    ->where('is_active', true)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingSubscription) {
                    return back()->withErrors(['subscription' => 'المستخدم لديه اشتراك نشط بالفعل في هذا الكتاب'])->withInput();
                }
            }

            $subscription->update($request->validated());

            DB::commit();

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'تم تحديث الاشتراك بنجاح');

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء تحديث الاشتراك'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();

            return redirect()->route('admin.subscriptions.index')
                ->with('success', 'تم حذف الاشتراك بنجاح');

        } catch (\Exception) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء حذف الاشتراك']);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->update(['is_active' => ! $subscription->is_active]);

            $status = $subscription->is_active ? 'تفعيل' : 'إلغاء تفعيل';
            return redirect()->route('admin.subscriptions.index')
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

            $subscriptions = Subscription::whereIn('id', $request->subscription_ids);

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

            return redirect()->route('admin.subscriptions.index')
                ->with('success', $message);

        } catch (\Exception) {
            DB::rollBack();
            return back()->withErrors(['error' => 'حدث خطأ أثناء تنفيذ العملية']);
        }
    }

    public function getUserSubscriptions($userId)
    {
        $user = User::with(['subscriptions.course', 'subscriptions.book'])->findOrFail($userId);
        return view('Admin.subscriptions.user-subscriptions', compact('user'));
    }

    public function getContentSubscriptions($type, $contentId)
    {
        $subscriptions = Subscription::with('user')
            ->where('subscription_type', $type)
            ->where($type . '_id', $contentId)
            ->paginate(15);

        $content = $type === 'course'
        ? Course::findOrFail($contentId)
        : Book::findOrFail($contentId);

        return view('Admin.subscriptions.content-subscriptions', compact('subscriptions', 'content', 'type'));
    }
}
