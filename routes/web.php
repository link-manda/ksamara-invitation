<?php

use App\Http\Controllers\Customer\InvitationController;
use App\Http\Controllers\PublicInvitationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified', 'customer'])->group(function () {
    Route::view('dashboard', 'customer.customer_dashboard')->name('dashboard');
    Route::get('invitations/create', [InvitationController::class, 'create'])->name('customer.invitations.create');
    Route::post('invitations', [InvitationController::class, 'store'])->name('customer.invitations.store');
    Route::get('invitations/{id}/edit', [InvitationController::class, 'edit'])->name('customer.invitations.edit');
    Route::put('invitations/{id}', [InvitationController::class, 'update'])->name('customer.invitations.update');
});

require __DIR__.'/settings.php';

// Route slug undangan harus diletakkan di paling bawah agar tidak bentrok dengan rute statis (seperti /dashboard, /login)
Route::get('/{slug}', [PublicInvitationController::class, 'show'])->name('public.invitation.show');
Route::post('/{slug}/rsvp', [PublicInvitationController::class, 'rsvp'])
    ->name('public.invitation.rsvp')
    ->middleware('throttle:5,1');
