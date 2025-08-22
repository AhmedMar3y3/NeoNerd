<?php

namespace App\Http\Controllers\User;

use App\Enums\Term;
use App\Models\Banner;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\Home\SubjectsResource;

class HomeController extends Controller
{
    use HttpResponses;

    public function banners()
    {
        return $this->successWithDataResponse(Banner::get(['id','title','image']));
    }

    public function getUserSubjects(Request $request)
    {
        $user = $request->user();
        if (!$user->is_academic_details_set) {
            return $this->failureResponse(__('messages.profile_completion_needed'));
        }

        $term = $request->get('term', Term::FIRST->value);        
        if (!in_array($term, [Term::FIRST->value, Term::SECOND->value])) {
            return $this->failureResponse(__('messages.invalid_term'));
        }

        $subjects = Subject::getSubjectsForUser($user, Term::from($term));
        return $this->successWithDataResponse(SubjectsResource::collection($subjects));
    }
}
