<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Mail\ResetOtpMail;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;





class AuthController extends Controller
{
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'password'          => 'required|string|min:6',
            'confirm_password'  => 'required|string|min:6|same:password',
            'role'              => 'required|in:admin,client',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $clientId = env('CLIENT_ID');
        $clientSecret = env('CLIENT_SECRET');

        if (empty($clientId) || empty($clientSecret)) {
            return response()->json([
                'message' => 'OAuth client credentials are not set in environment variables.',
                'error' => 'missing_client_credentials',
                'details' => 'Please set CLIENT_ID and CLIENT_SECRET in your .env file.'
            ], 500);
        }

        $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'success to obtain token',
                'data' => $response->json()
            ]);
        } else {
            \Log::error('OAuth token request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json([
                "message" => 'Failed to obtain token',
                "error" => $response->json(),
                "data" => $response->json()
            ], $response->status());
        }
    }

    public function sendResetOtp(Request $request)
{
    $request->validate(['email' => 'required|email']);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $otp = rand(100000, 999999); // 6-digit OTP
    Cache::put('password_otp_' . $request->email, $otp, now()->addMinutes(10));

    // SMS or just log OTP for now
    Mail::to($user->email)->send(new ResetOtpMail($otp));
    Log::info("Reset OTP for {$request->email} is: {$otp}");

    return response()->json([
        'message' => 'OTP sent to your email.',
        'otp' => $otp  // <--- only for testing
        ]);
    }

    public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|digits:6',
    ]);

    $email = $request->email;
    $enteredOtp = $request->otp;
    $cachedOtp = Cache::get('reset_otp_' . $email);

    if (!$cachedOtp) {
        return response()->json(['message' => 'OTP expired or not found.'], 404);
    }

    if ($enteredOtp != $cachedOtp) {
        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

    // Optional: Invalidate OTP after successful verification
    Cache::forget('reset_otp_' . $email);

    // Mark email as verified (optional flag for next step)
    Cache::put('otp_verified_' . $email, true, now()->addMinutes(10));

    return response()->json(['message' => 'OTP verified successfully.'], 200);
}

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
