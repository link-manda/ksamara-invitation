<?php

use App\Http\Controllers\Admin\PackageController;
use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'admin.dashboard')->name('dashboard');

Route::resource('packages', PackageController::class)->except('show');
