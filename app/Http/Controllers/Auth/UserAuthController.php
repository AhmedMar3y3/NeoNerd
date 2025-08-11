<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\User\CompleteProfileRequest;
use App\Http\Requests\Auth\User\RegisterOrLoginRequest;
use App\Http\Requests\Auth\User\VerifyPhoneRequest;
use App\Http\Resources\Auth\UserAuthResource;
use App\Models\User;
use App\Services\AcademicProfileService;
use App\Services\HypersenderService;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    use HttpResponses;

    public function __construct(
        private AcademicProfileService $academicProfileService,
        private HypersenderService $hypersenderService
    ) {}

    public function registerOrLogin(RegisterOrLoginRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            $user = User::create([
                'phone' => $request->phone,
                'code' => random_int(100000, 999999),
                'is_verified' => false,
            ]);
        } else {
            $user->update([
                'code' => random_int(100000, 999999),
                'is_verified' => false,
            ]);
        }

        // Send verification code via WhatsApp
        $this->hypersenderService->sendMessage(
            $user->phone,
            "Your verification code is: {$user->code}"
        );

        return $this->successWithDataResponse([
            'user' => new UserAuthResource($user),
            'message' => 'Verification code sent successfully'
        ]);
    }

    public function verifyCode(VerifyPhoneRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'phone' => 'User not found.'
            ]);
        }

        if ($user->code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => 'Invalid verification code.'
            ]);
        }

        $user->markAsVerified();

        return $this->successWithDataResponse([
            'user' => new UserAuthResource($user),
            'token' => $user->login(),
            'message' => 'Phone verified successfully'
        ]);
    }

    public function resendCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|exists:users,phone'
        ]);

        $user = User::where('phone', $request->phone)->first();
        $user->sendVerificationCode();

        // Send verification code via WhatsApp
        $this->hypersenderService->sendMessage(
            $user->phone,
            "Your verification code is: {$user->code}"
        );

        return $this->successResponse('Verification code resent successfully');
    }

    public function completeProfile(CompleteProfileRequest $request)
    {
        $user = $request->user();

        if ($user->profile_completed()) {
            return $this->failureResponse('Profile already completed');
        }

        try {
            $this->academicProfileService->completeAcademicProfile($user, $request->validated());

            return $this->successWithDataResponse([
                'user' => new UserAuthResource($user),
                'message' => 'Profile completed successfully'
            ]);
        } catch (\Exception $e) {
            return $this->failureResponse($e->getMessage());
        }
    }

    public function getProfile(Request $request)
    {
        $user = $request->user()->load([
            'university',
            'college',
            'grade',
            'secondaryType'
        ]);

        return $this->successWithDataResponse([
            'user' => new UserAuthResource($user)
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->successResponse('Logged out successfully');
    }
}
