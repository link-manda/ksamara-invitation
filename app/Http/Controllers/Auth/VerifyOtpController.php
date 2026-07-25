<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendEmailOtpNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyOtpController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
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

        if ($request->wantsJson() || $request->ajax()) {
            $targetUrl = $user->role === UserRole::Admin
                ? route('admin.dashboard')
                : route('dashboard');

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi email berhasil.',
                'redirect_url' => $targetUrl,
            ]);
        }

        return redirect()->intended('/dashboard')->with('status', 'email-verified');
    }

    public function resend(Request $request): RedirectResponse|JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            if ($request->wantsJson() || $request->ajax()) {
                $targetUrl = $user->role === UserRole::Admin ? route('admin.dashboard') : route('dashboard');

                return response()->json(['redirect_url' => $targetUrl]);
            }

            return redirect()->intended('/dashboard');
        }

        $otpCode = $user->generateOtp();
        $user->notify(new SendEmailOtpNotification($otpCode));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP baru telah berhasil dikirimkan ke email Anda.',
            ]);
        }

        return back()->with('status', 'verification-link-sent');
    }
}
