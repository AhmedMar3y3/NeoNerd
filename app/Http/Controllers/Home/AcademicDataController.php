<?php

namespace App\Http\Controllers\Home;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Services\AcademicProfileService;
use App\Http\Requests\AcademicData\GradeByCollegeRequest;
use App\Http\Requests\AcademicData\CollegeByUniversityRequest;


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
    public function getCollegesByUniversity(CollegeByUniversityRequest $request)
    {
        $colleges = $this->academicProfileService->getCollegesByUniversity($request->university_id);
        return $this->successWithDataResponse($colleges);
    }

    /**
     * Get grades by college
     */
    public function getGradesByCollege(GradeByCollegeRequest $request)
    {
        $grades = $this->academicProfileService->getGradesByCollege($request->college_id);
        return $this->successWithDataResponse($grades);
    }

    /**
     * Get all academic data
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
}
