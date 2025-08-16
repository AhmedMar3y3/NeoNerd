<?php

namespace App\Filters;

use App\Enums\Term;
use App\Models\Subject;
use App\Enums\SubjectType;
use App\Models\CollegeType;
use App\Enums\AcademicLevel;
use Illuminate\Http\Request;
use App\Enums\SecondaryType;
use App\Enums\SecondaryGrade;
use App\Enums\SecondarySection;
use Illuminate\Database\Eloquent\Builder;

class SubjectFilter
{
    public function apply(Request $request, Builder $query): Builder
    {
        // Search filter
        if ($request->filled('search')) {
            $this->applySearchFilter($request, $query);
        }

        // Academic level filter
        if ($request->filled('academic_level')) {
            $this->applyAcademicLevelFilter($request, $query);
        }

        // Status filter
        if ($request->filled('status')) {
            $this->applyStatusFilter($request, $query);
        }

        // Term filter
        if ($request->filled('term')) {
            $this->applyTermFilter($request, $query);
        }

        // Subject type filter
        if ($request->filled('type')) {
            $this->applySubjectTypeFilter($request, $query);
        }

        // College type filter (for university subjects)
        if ($request->filled('college_type_id')) {
            $this->applyCollegeTypeFilter($request, $query);
        }

        // Grade level filter (for university subjects)
        if ($request->filled('grade_level')) {
            $this->applyGradeLevelFilter($request, $query);
        }

        // Secondary type filter (for secondary subjects)
        if ($request->filled('secondary_type')) {
            $this->applySecondaryTypeFilter($request, $query);
        }

        // Secondary grade filter (for secondary subjects)
        if ($request->filled('secondary_grade')) {
            $this->applySecondaryGradeFilter($request, $query);
        }

        // Secondary section filter (for secondary subjects)
        if ($request->filled('secondary_section')) {
            $this->applySecondarySectionFilter($request, $query);
        }

        // Sorting
        $this->applySorting($request, $query);

        return $query;
    }

    private function applySearchFilter(Request $request, Builder $query): void
    {
        $search = $request->search;
        $query->where('name', 'like', "%{$search}%");
    }

    private function applyAcademicLevelFilter(Request $request, Builder $query): void
    {
        $query->where('academic_level', AcademicLevel::from($request->academic_level));
    }

    private function applyStatusFilter(Request $request, Builder $query): void
    {
        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
    }

    private function applyTermFilter(Request $request, Builder $query): void
    {
        $query->where('term', Term::from($request->term));
    }

    private function applySubjectTypeFilter(Request $request, Builder $query): void
    {
        $query->where('type', SubjectType::from($request->type));
    }

    private function applyCollegeTypeFilter(Request $request, Builder $query): void
    {
        $query->where('college_type_id', $request->college_type_id);
    }

    private function applyGradeLevelFilter(Request $request, Builder $query): void
    {
        $query->where('grade_level', $request->grade_level);
    }

    private function applySecondaryTypeFilter(Request $request, Builder $query): void
    {
        $query->where('secondary_type', SecondaryType::from($request->secondary_type));
    }

    private function applySecondaryGradeFilter(Request $request, Builder $query): void
    {
        $query->where('secondary_grade', SecondaryGrade::from($request->secondary_grade));
    }

    private function applySecondarySectionFilter(Request $request, Builder $query): void
    {
        $query->where('secondary_section', SecondarySection::from($request->secondary_section));
    }

    private function applySorting(Request $request, Builder $query): void
    {
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
    }

    public function getFilterOptions(): array
    {
        return [
            'academic_levels' => AcademicLevel::cases(),
            'terms' => Term::cases(),
            'subject_types' => SubjectType::cases(),
            'college_types' => CollegeType::all(),
            'secondary_types' => SecondaryType::cases(),
            'secondary_grades' => SecondaryGrade::cases(),
            'secondary_sections' => SecondarySection::cases(),
        ];
    }

    public function getStatistics(): array
    {
        return [
            'activeSubjects' => Subject::where('is_active', true)->count(),
            'universitySubjects' => Subject::where('academic_level', AcademicLevel::UNIVERSITY)->count(),
            'secondarySubjects' => Subject::where('academic_level', AcademicLevel::SECONDARY)->count(),
            'totalSubjects' => Subject::count(),
        ];
    }
}
