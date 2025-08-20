<?php
namespace App\Filters;

use App\Enums\Gender;
use App\Enums\AcademicLevel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class UserFilter
{
    public function apply(Request $request, Builder $query): Builder
    {
        // Search filter
        if ($request->filled('search')) {
            $this->applySearchFilter($request, $query);
        }

        // Status filter
        if ($request->filled('status')) {
            $this->applyStatusFilter($request, $query);
        }

        // Verification filter
        if ($request->filled('verified')) {
            $this->applyVerificationFilter($request, $query);
        }

        // Subscription filter
        if ($request->filled('subscription')) {
            $this->applySubscriptionFilter($request, $query);
        }

        // Academic level filter
        if ($request->filled('academic_level')) {
            $this->applyAcademicLevelFilter($request, $query);
        }

        // Gender filter
        if ($request->filled('gender')) {
            $this->applyGenderFilter($request, $query);
        }

        // Profile completion filter
        if ($request->filled('profile_completed')) {
            $this->applyProfileCompletionFilter($request, $query);
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $this->applyDateFromFilter($request, $query);
        }

        if ($request->filled('date_to')) {
            $this->applyDateToFilter($request, $query);
        }

        // Sorting
        $this->applySorting($request, $query);

        return $query;
    }

    private function applySearchFilter(Request $request, Builder $query): void
    {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    private function applyStatusFilter(Request $request, Builder $query): void
    {
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
    }

    private function applyVerificationFilter(Request $request, Builder $query): void
    {
        if ($request->verified === 'verified') {
            $query->where('is_verified', true);
        } elseif ($request->verified === 'unverified') {
            $query->where('is_verified', false);
        }
    }

    private function applySubscriptionFilter(Request $request, Builder $query): void
    {
        if ($request->subscription === 'subscribed') {
            $query->whereHas('subscriptions', function ($q) {
                $q->where('is_active', true);
            });
        } elseif ($request->subscription === 'not_subscribed') {
            $query->whereDoesntHave('subscriptions', function ($q) {
                $q->where('is_active', true);
            });
        }
    }

    private function applyAcademicLevelFilter(Request $request, Builder $query): void
    {
        $query->where('academic_level', AcademicLevel::from($request->academic_level));
    }

    private function applyGenderFilter(Request $request, Builder $query): void
    {
        $query->where('gender', Gender::from($request->gender));
    }

    private function applyProfileCompletionFilter(Request $request, Builder $query): void
    {
        if ($request->profile_completed === 'completed') {
            $query->where('is_academic_details_set', true);
        } elseif ($request->profile_completed === 'incomplete') {
            $query->where('is_academic_details_set', false);
        }
    }

    private function applyDateFromFilter(Request $request, Builder $query): void
    {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    private function applyDateToFilter(Request $request, Builder $query): void
    {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    private function applySorting(Request $request, Builder $query): void
    {
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
    }

    public function getFilterOptions(): array
    {
        return [
            'academic_levels' => AcademicLevel::cases(),
            'genders'         => Gender::cases(),
        ];
    }
}
