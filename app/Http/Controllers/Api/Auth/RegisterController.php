<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

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

        return response()->json(['message' => 'User registered successfully. Verification code sent.']);
    }

}
