<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\CompleteProfileRequest;
use App\Services\HypersenderService;
use App\Http\Resources\Auth\UserAuthResource;
use App\Http\Requests\Auth\User\VerifyPhoneRequest;
use App\Http\Requests\Auth\User\RegisterOrLoginRequest;

class UserAuthController extends Controller
{
    use HttpResponses;

    public function registerOrLogin(RegisterOrLoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->validated());
            $user->sendVerificationCode();
            $sent = HypersenderService::sendMessage($user->phone, 'كود التفعيل الخاص بك هو: ' . $user->code);

            if (!$sent) {
                DB::rollBack();
                return $this->failureResponse(__('messages.failed_to_send_code'));
            }

            DB::commit();
            return $this->successResponse(__('messages.code_sent_successfully'));
        } catch (\Exception) {
            DB::rollBack();
            return $this->failureResponse(__('messages.failed_to_send_code'));
        }
    }

    public function verifyCode(VerifyPhoneRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user || $user->code !== $request->code) {
            return $this->failureResponse(__('messages.invalid_data'));
        }

        $user->markAsVerified();
        return $this->successWithDataResponse(UserAuthResource::make($user)->setToken($user->login()));
    }

    public function resendCode(RegisterOrLoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return $this->failureResponse(__('messages.invalid_data'));
        }

        $user->sendVerificationCode();
        $sent = HypersenderService::sendMessage($user->phone, 'كود التفعيل الخاص بك هو: ' . $user->code);

        if (!$sent) {
            return $this->failureResponse(__('messages.failed_to_send_code'));
        }

        return $this->successResponse(__('messages.code_sent_successfully'));
    }

    public function completeProfile(CompleteProfileRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());
        return $this->successResponse(__('messages.profile_updated_successfully'));
    }

    //Logout User
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse(__('auth.logged_out'));
    }
}
