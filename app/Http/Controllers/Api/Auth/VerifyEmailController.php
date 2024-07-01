<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    public function verifyEmail(verifyEmailRequest $request)
    {
        $request->validated();
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $verificationCode = rand(100000, 999999);
        VerificationCode::create([
            'user_id' => $user->id,
            'code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);
        Mail::raw("Your verification code is: $verificationCode", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Email Verification Code');
        });

        return response()->json(['message' => 'Verification code sent.']);
    }

    public function sendCode(Request $request)
    {
//    $request->validated();

        $verificationCode = VerificationCode::where('code', $request->code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$verificationCode) {
            return response()->json(['message' => 'Invalid or expired verification code.'], 400);
        }

        $user = User::find($verificationCode->user_id);
        $user->email_verified_at = now();
        $user->save();

        $verificationCode->delete();

        return response()->json(['message' => 'Email verified successfully.']);
    }

}
