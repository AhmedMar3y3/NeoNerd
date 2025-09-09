<?php
namespace App\Filters;

use App\Models\Doctor;
use App\Models\University;
use Illuminate\Http\Request;

class DoctorFilter
{
    public function apply(Request $request)
    {
        $query = Doctor::with(['university']);

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        // Filter by partner status
        if ($request->filled('partner_status')) {
            $partnerStatus = $request->partner_status === 'partner';
            $query->where('is_partner', $partnerStatus);
        }

        // Filter by university
        if ($request->filled('university_id')) {
            $query->where('university_id', $request->university_id);
        }

        // Filter by profile completion
        if ($request->filled('profile_completion')) {
            switch ($request->profile_completion) {
                case 'complete':
                    $query->whereNotNull('phone')
                        ->whereNotNull('specialization')
                        ->whereNotNull('bio');
                    break;
                case 'incomplete':
                    $query->where(function ($q) {
                        $q->whereNull('phone')
                            ->orWhereNull('specialization')
                            ->orWhereNull('bio');
                    });
                    break;
            }
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy    = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSortFields = ['name', 'email', 'created_at', 'is_active', 'is_partner'];
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
            'universities' => University::orderBy('name')->get(),
        ];
    }

    public function getStatistics()
    {
        $totalDoctors     = Doctor::count();
        $activeDoctors    = Doctor::where('is_active', true)->count();
        $inactiveDoctors  = Doctor::where('is_active', false)->count();
        $partnerDoctors   = Doctor::where('is_partner', true)->count();
        $completeProfiles = Doctor::whereNotNull('phone')
            ->whereNotNull('specialization')
            ->whereNotNull('bio')
            ->count();
        $incompleteProfiles = $totalDoctors - $completeProfiles;

        return [
            'total'               => $totalDoctors,
            'active'              => $activeDoctors,
            'inactive'            => $inactiveDoctors,
            'partners'            => $partnerDoctors,
            'complete_profiles'   => $completeProfiles,
            'incomplete_profiles' => $incompleteProfiles,
        ];
    }
}
