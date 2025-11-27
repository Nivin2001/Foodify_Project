<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResendOtpRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'User registered successfully. OTP sent.',
            'phone' => $result['user']->phone,
            'otp' => $result['otp'], // للتجربة فقط
        ]);
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        if ($this->authService->verifyOtp($request->phone, $request->otp)) {
            return response()->json(['message' => 'Phone verified successfully']);
        }

        return response()->json(['message' => 'Invalid or expired OTP'], 422);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result) return response()->json(['message' => 'Invalid credentials'], 401);
        if ($result === 'not_verified') return response()->json(['message' => 'Phone not verified'], 403);

        return response()->json([
            'message' => 'Login successful',
            'token' => $result['token'],
            'user' => $result['user'],
        ]);
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $otp = $this->authService->resendOtp($request->phone);

        return response()->json([
            'message' => 'OTP resent successfully',
            'otp' => $otp, // للتجربة فقط
        ]);
    }

    public function profile(Request $request)
{
    $user = $this->authService->profile($request->user());
    return response()->json($user);
}

public function logout(Request $request)
{
    $this->authService->logout($request->user());
    return response()->json(['message' => 'Logged out successfully']);
}

}
