<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\UpdatePersonalDataRequest;
use App\Http\Requests\Auth\User\UpdateStudyInfoRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\HypersenderService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    use HttpResponses;
    public function updatePersonalInfo(UpdatePersonalDataRequest $request)
    {
        $user = Auth::user();   // get the logged-in user
        $data = $request->validated();

        $user->update($data);   // update only this user's record

        return $this->successWithDataResponse(UserResource::make($user));
    }

    public function updateStudyInfo(UpdatePhoneRequest $request){

        $user = Auth::user();
        $data = $request->validated();
        $user->update($data);
        return $this->successWithDataResponse(UserResource::make($user));

    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^20\d{10}$/|unique:users,phone',
        ]);

        try {
            $user = auth()->user(); // get logged-in user

            $user->phone = $request->phone;
            $user->is_active = false; // deactivate until new phone is verified
            $user->save();

            // send new verification code
            $user->sendVerificationCode();
            HypersenderService::sendMessage(
                $user->phone,
                'كود التفعيل الخاص بك هو: ' . $user->code
            );

            return $this->successResponse(__('messages.code_sent_successfully'));
        } catch (\Exception $e) {
            return $this->failureResponse(__('messages.failed_to_update_phone'));
        }
    }

}
