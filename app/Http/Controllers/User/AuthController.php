<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\HypersenderService;
use App\Services\AcademicProfileService;
use App\Http\Resources\Auth\UserAuthResource;
use App\Http\Requests\Auth\User\VerifyPhoneRequest;
use App\Http\Requests\Auth\User\CompleteProfileRequest;
use App\Http\Requests\Auth\User\RegisterOrLoginRequest;



class AuthController extends Controller
{
    use HttpResponses;

    public function __construct(
        private AcademicProfileService $academicProfileService,
        private HypersenderService $hypersenderService
    ) {}

    public function registerOrLogin(RegisterOrLoginRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                $user = User::create($request->validated());
                $user->sendVerificationCode();
            }

            // if (!$user->is_active) {
            //     return $this->failureResponse(__('messages.user_not_active'));
            // }

            $user->sendVerificationCode();
            $sent = HypersenderService::sendMessage($user->phone, 'كود التفعيل الخاص بك هو: ' . $user->code);

            if (!$sent) {
                DB::rollBack();
                return $this->failureResponse(__('messages.failed_to_send_code'));
            }

            DB::commit();
            \Log::info('Verification code sent successfully via Hypersender', ['user_id' => $user->id, 'phone' => $user->phone]);
            return $this->successResponse(__('messages.code_sent_successfully'));
        } catch (\Exception $e) {
            \Log::error('Exception during registerOrLogin', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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
        $user = $request->user();

        if ($user->profile_completed()) {
            return $this->failureResponse(__('messages.profile_already_completed'));
        }

        try {
            $this->academicProfileService->completeAcademicProfile($user, $request->validated());

            return $this->successWithDataResponse(UserAuthResource::make($user)->setToken($user->login()));
        } catch (\Exception) {
            return $this->failureResponse(__('messages.failed_to_complete_profile'));
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse('Logged out successfully');
    }
}
