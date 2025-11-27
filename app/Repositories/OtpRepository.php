<?php

namespace App\Repositories;

use App\Models\OtpCode;

class OtpRepository
{
    public function create(array $data)
    {
        return OtpCode::create($data);
    }

    public function findValidOtp(int $userId, string $otp)
    {
        return OtpCode::where('user_id', $userId)
                      ->where('otp', $otp)
                      ->where('used', false)
                      ->where('expires_at', '>', now())
                      ->first();
    }
}
