<?php

use App\Models\User;
use App\Notifications\SendEmailOtpNotification;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::emailVerification());
});

test('email verification screen can be rendered', function () {
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get(route('verification.notice'));

    $response->assertOk();
});

test('email can be verified with valid 6-digit OTP', function () {
    $user = User::factory()->unverified()->create();
    $otp = $user->generateOtp();

    $response = $this->actingAs($user)->post(route('verification.otp.store'), [
        'otp' => $otp,
    ]);

    expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
    $response->assertRedirect('/dashboard');
});

test('email is not verified with invalid 6-digit OTP', function () {
    $user = User::factory()->unverified()->create();
    $user->generateOtp();

    $response = $this->actingAs($user)->post(route('verification.otp.store'), [
        'otp' => '000000',
    ]);

    $response->assertSessionHasErrors('otp');
    expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
});

test('resend email OTP notification generates new OTP and sends notification', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->post(route('verification.send'));

    Notification::assertSentTo($user, SendEmailOtpNotification::class);
    $response->assertSessionHas('status', 'verification-link-sent');
});
