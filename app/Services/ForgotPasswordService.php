<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\OtpRepository;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordService
{
    protected $userRepo;
    protected $otpRepo;

    public function __construct(UserRepository $userRepo, OtpRepository $otpRepo)
    {
        $this->userRepo = $userRepo;
        $this->otpRepo = $otpRepo;
    }

    public function sendResetOtp(string $phone)
    {
        $user = $this->userRepo->findByPhone($phone);

        $otp = rand(100000, 999999);

        $this->otpRepo->create([
            'user_id' => $user->id,
            'otp' => $otp,
            'used' => false,
            'expires_at' => now()->addMinutes(5),
        ]);

        return $otp;
    }

    public function resetPassword(array $data): bool
    {
        $user = $this->userRepo->findByPhone($data['phone']);

        $otpRecord = $this->otpRepo->findValidOtp($user->id, $data['otp']);

        if (!$otpRecord) return false;

        $otpRecord->update(['used' => true]);

        $user->password = Hash::make($data['password']);
        $this->userRepo->save($user);

        return true;
    }
}
