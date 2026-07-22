<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::view('dashboard', 'admin.admin_dashboard')->name('dashboard');

Route::resource('packages', PackageController::class)->except('show');
Route::resource('templates', TemplateController::class)->except('show');
Route::resource('users', UserController::class)->except('show');
