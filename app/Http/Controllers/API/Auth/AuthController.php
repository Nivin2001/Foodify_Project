<?php
namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);
        OtpCode::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        return response()->json([
            'message' => 'User registered successfully. OTP generated.',
            'user' => $user,
            'otp' => $otp // فقط للتجربة، لاحقًا أرسل SMS
        ]);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        $otpRecord = OtpCode::where('user_id', $request->user_id)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        // Mark OTP as used
        $otpRecord->update(['used' => true]);

        // ✅ Update phone_verified_at
        $user = User::find($otpRecord->user_id);
        $user->phone_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'Phone verified successfully.'
        ]);
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        $otp = rand(100000, 999999);
        OtpCode::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        return response()->json([
            'message' => 'OTP resent successfully.',
            'otp' => $otp // للتجربة فقط
        ]);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|email|exists:users,email',
            'phone' => 'required_without:email|exists:users,phone',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if (!$user->phone_verified_at) {
            return response()->json(['message' => 'Phone not verified'], 403);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
