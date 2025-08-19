<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\HypersenderService;
use App\Http\Requests\Auth\User\UpdateStudyInfoRequest;
use App\Http\Requests\Auth\User\UpdatePersonalDataRequest;

class ProfileController extends Controller
{
    use HttpResponses;
    public function updatePersonalInfo(UpdatePersonalDataRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return $this->successResponse(__('messages.personal_info_updated'));
    }

    public function updateStudyInfo(UpdateStudyInfoRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return $this->successResponse(__('messages.study_info_updated'));
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^20\d{10}$/|unique:users,phone',
        ]);

        try {
            $user            = Auth::user();
            $user->phone     = $request->phone;
            $user->is_active = false;
            $user->save();
            $user->sendVerificationCode();
            HypersenderService::sendMessage(
                $user->phone,
                'كود التفعيل الخاص بك هو: ' . $user->code
            );

            return $this->successResponse(__('messages.code_sent_successfully'));
        } catch (\Exception) {
            return $this->failureResponse(__('messages.failed_to_update_phone'));
        }
    }

}
