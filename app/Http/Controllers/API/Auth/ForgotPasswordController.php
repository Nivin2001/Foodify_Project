<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Services\ForgotPasswordService;
use App\Http\Requests\Auth\SendResetOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;

class ForgotPasswordController extends Controller
{
    protected $service;

    public function __construct(ForgotPasswordService $service)
    {
        $this->service = $service;
    }

    public function sendResetOtp(SendResetOtpRequest $request)
    {
        $otp = $this->service->sendResetOtp($request->phone);

        return response()->json([
            'message' => 'Reset OTP sent successfully',
            'otp' => $otp, // للتجربة فقط
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $success = $this->service->resetPassword($request->validated());

        if (!$success) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        return response()->json(['message' => 'Password reset successfully']);
    }
}
