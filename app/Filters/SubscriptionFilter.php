<?php
namespace App\Filters;

use App\Enums\SubscriptionType;
use App\Models\Book;
use App\Models\Course;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionFilter
{
    public function apply(Request $request)
    {
        $query = Subscription::with(['user', 'course', 'book']);

        // Search by user name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by subscription type
        if ($request->filled('subscription_type')) {
            $query->where('subscription_type', $request->subscription_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by book
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by recent subscriptions (last 7, 30, 90 days)
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

        // Sort
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['created_at', 'is_active', 'subscription_type'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate(15);
    }

    public function getFilterOptions()
    {
        return [
            'users'              => User::orderBy('first_name')->get(),
            'courses'            => Course::where('is_active', true)->orderBy('title')->get(),
            'books'              => Book::where('is_active', true)->orderBy('title')->get(),
            'subscription_types' => [
                ['value' => SubscriptionType::COURSE->value, 'label' => 'دورة'],
                ['value' => SubscriptionType::BOOK->value, 'label' => 'كتاب'],
            ],
        ];
    }

    public function getStatistics()
    {
        $totalSubscriptions    = Subscription::count();
        $activeSubscriptions   = Subscription::where('is_active', true)->count();
        $inactiveSubscriptions = Subscription::where('is_active', false)->count();

        $courseSubscriptions = Subscription::where('subscription_type', SubscriptionType::COURSE->value)->count();
        $bookSubscriptions   = Subscription::where('subscription_type', SubscriptionType::BOOK->value)->count();

        $activeCourseSubscriptions = Subscription::where('subscription_type', SubscriptionType::COURSE->value)
            ->where('is_active', true)->count();
        $activeBookSubscriptions = Subscription::where('subscription_type', SubscriptionType::BOOK->value)
            ->where('is_active', true)->count();

        // Recent subscriptions
        $recent7Days  = Subscription::where('created_at', '>=', now()->subDays(7))->count();
        $recent30Days = Subscription::where('created_at', '>=', now()->subDays(30))->count();
        $recent90Days = Subscription::where('created_at', '>=', now()->subDays(90))->count();

        // Unique users with subscriptions
        $uniqueUsers       = Subscription::distinct('user_id')->count();
        $uniqueActiveUsers = Subscription::where('is_active', true)->distinct('user_id')->count();

        return [
            'total'                       => $totalSubscriptions,
            'active'                      => $activeSubscriptions,
            'inactive'                    => $inactiveSubscriptions,
            'course_subscriptions'        => $courseSubscriptions,
            'book_subscriptions'          => $bookSubscriptions,
            'active_course_subscriptions' => $activeCourseSubscriptions,
            'active_book_subscriptions'   => $activeBookSubscriptions,
            'recent_7_days'               => $recent7Days,
            'recent_30_days'              => $recent30Days,
            'recent_90_days'              => $recent90Days,
            'unique_users'                => $uniqueUsers,
            'unique_active_users'         => $uniqueActiveUsers,
        ];
    }
}
