<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\OtpRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepo;
    protected $otpRepo;

    public function __construct(UserRepository $userRepo, OtpRepository $otpRepo)
    {
        $this->userRepo = $userRepo;
        $this->otpRepo = $otpRepo;
    }

    public function register(array $data)
    {
        $user = $this->userRepo->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        $otp = rand(100000, 999999);

        $this->otpRepo->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        return ['user' => $user, 'otp' => $otp];
    }

    public function verifyOtp(string $phone, string $otp): bool
    {
        $user = $this->userRepo->findByPhone($phone);

        if (!$user) return false;

        $otpRecord = $this->otpRepo->findValidOtp($user->id, $otp);

        if (!$otpRecord) return false;

        $otpRecord->update(['used' => true]);
        $user->phone_verified_at = now();
        $this->userRepo->save($user);

        return true;
    }

    public function login(array $data)
    {
        $user = $this->userRepo->findByEmailOrPhone($data);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        if (!$user->phone_verified_at) return 'not_verified';

        $token = $user->createToken('api-token')->plainTextToken;

        return ['user' => $user, 'token' => $token];
    }

    public function resendOtp(string $phone)
    {
        $user = $this->userRepo->findByPhone($phone);

        $otp = rand(100000, 999999);

        $this->otpRepo->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $otp;
    }

    public function profile($user)
    {
        return $user; 
    }

    public function logout($user)
    {
        $user->currentAccessToken()->delete();
        return true;
    }
}
