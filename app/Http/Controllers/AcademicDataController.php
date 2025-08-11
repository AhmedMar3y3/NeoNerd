<?php

namespace App\Http\Controllers;

use App\Services\AcademicProfileService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Enums\AcademicLevel;

class AcademicDataController extends Controller
{
    use HttpResponses;

    public function __construct(
        private AcademicProfileService $academicProfileService
    ) {}

    /**
     * Get universities list
     */
    public function getUniversities()
    {
        $universities = $this->academicProfileService->getUniversities();
        return $this->successWithDataResponse($universities);
    }

    /**
     * Get colleges by university
     */
    public function getCollegesByUniversity(Request $request)
    {
        $request->validate([
            'university_id' => 'required|exists:universities,id'
        ]);

        $colleges = $this->academicProfileService->getCollegesByUniversity($request->university_id);
        return $this->successWithDataResponse($colleges);
    }

    /**
     * Get grades by college
     */
    public function getGradesByCollege(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id'
        ]);

        $grades = $this->academicProfileService->getGradesByCollege($request->college_id);
        return $this->successWithDataResponse($grades);
    }

    /**
     * Get secondary types
     */
    public function getSecondaryTypes()
    {
        $secondaryTypes = $this->academicProfileService->getSecondaryTypes();
        return $this->successWithDataResponse($secondaryTypes);
    }

    /**
     * Get secondary grades
     */
    public function getSecondaryGrades()
    {
        $grades = $this->academicProfileService->getSecondaryGrades();
        return $this->successWithDataResponse($grades);
    }

    /**
     * Get secondary sections
     */
    public function getSecondarySections()
    {
        $sections = $this->academicProfileService->getSecondarySections();
        return $this->successWithDataResponse($sections);
    }

    /**
     * Get scientific branches
     */
    public function getScientificBranches()
    {
        $branches = $this->academicProfileService->getScientificBranches();
        return $this->successWithDataResponse($branches);
    }

    /**
     * Get all academic data for initialization
     */
    public function getAcademicData()
    {
        $data = [
            'universities' => $this->academicProfileService->getUniversities(),
            'secondary_types' => $this->academicProfileService->getSecondaryTypes(),
            'secondary_grades' => $this->academicProfileService->getSecondaryGrades(),
            'secondary_sections' => $this->academicProfileService->getSecondarySections(),
            'scientific_branches' => $this->academicProfileService->getScientificBranches(),
        ];

        return $this->successWithDataResponse($data);
    }

    /**
     * Get subjects for authenticated user
     */
    public function getUserSubjects(Request $request)
    {
        $user = $request->user();
        
        if (!$user->is_academic_details_set) {
            return $this->failureResponse('يجب إكمال الملف الشخصي الأكاديمي أولاً');
        }

        $subjects = Subject::getSubjectsForUser($user);
        return $this->successWithDataResponse($subjects);
    }

    /**
     * Get subjects by college and grade (for university)
     */
    public function getSubjectsByCollegeGrade(Request $request)
    {
        $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'grade_level' => 'required|integer|min:1|max:6'
        ]);

        $subjects = Subject::getSubjectsForCollegeGrade($request->college_id, $request->grade_level);
        return $this->successWithDataResponse($subjects);
    }

    /**
     * Get subjects by secondary type, grade and section
     */
    public function getSubjectsBySecondaryType(Request $request)
    {
        $request->validate([
            'secondary_type_id' => 'required|exists:secondary_types,id',
            'grade' => 'required|in:first,second,third',
            'section' => 'nullable|in:literal,scientific'
        ]);

        $subjects = Subject::getSubjectsForSecondaryType($request->secondary_type_id, $request->grade, $request->section);
        return $this->successWithDataResponse($subjects);
    }

    /**
     * Get subjects by secondary grade and section (legacy method)
     */
    public function getSubjectsBySecondaryGrade(Request $request)
    {
        $request->validate([
            'grade' => 'required|in:first,second,third',
            'section' => 'nullable|in:literal,scientific'
        ]);

        $subjects = Subject::getSubjectsForSecondaryGrade($request->grade, $request->section);
        return $this->successWithDataResponse($subjects);
    }

    /**
     * Get all subjects for a specific academic level
     */
    public function getSubjectsByAcademicLevel(Request $request)
    {
        $request->validate([
            'academic_level' => 'required|in:university,secondary'
        ]);

        $subjects = Subject::where('academic_level', $request->academic_level)
            ->active()
            ->get();

        return $this->successWithDataResponse($subjects);
    }
}
