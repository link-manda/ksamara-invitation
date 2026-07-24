<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendEmailOtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyOtpController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 angka.',
        ]);

        /** @var User $user */
        $user = $request->user();

        if (! $user->verifyOtp($request->input('otp'))) {
            throw ValidationException::withMessages([
                'otp' => ['Kode OTP yang Anda masukkan salah atau telah kadaluwarsa.'],
            ]);
        }

        return redirect()->intended('/dashboard')->with('status', 'email-verified');
    }

    public function resend(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $otpCode = $user->generateOtp();
        $user->notify(new SendEmailOtpNotification($otpCode));

        return back()->with('status', 'verification-link-sent');
    }
}
