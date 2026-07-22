<?php

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\InvitationController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\RsvpController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\PublicInvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified', 'customer'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('invitations/create', [InvitationController::class, 'create'])->name('customer.invitations.create');
    Route::post('invitations', [InvitationController::class, 'store'])->name('customer.invitations.store');
    Route::get('invitations/{id}/edit', [InvitationController::class, 'edit'])->name('customer.invitations.edit');
    Route::put('invitations/{id}', [InvitationController::class, 'update'])->name('customer.invitations.update');
    Route::patch('invitations/{id}/toggle-status', [InvitationController::class, 'toggleStatus'])->name('customer.invitations.toggle-status');
    Route::delete('invitations/{id}', [InvitationController::class, 'destroy'])->name('customer.invitations.destroy');
    Route::get('invitations/{id}/rsvps', [RsvpController::class, 'index'])->name('customer.invitations.rsvps.index');

    Route::get('orders', [OrderController::class, 'index'])->name('customer.orders.index');
});

require __DIR__.'/settings.php';

// Route slug undangan harus diletakkan di paling bawah agar tidak bentrok dengan rute statis (seperti /dashboard, /login)
Route::get('/{slug}', [PublicInvitationController::class, 'show'])->name('public.invitation.show');
Route::post('/{slug}/rsvp', [PublicInvitationController::class, 'rsvp'])
    ->name('public.invitation.rsvp')
    ->middleware('throttle:5,1');
