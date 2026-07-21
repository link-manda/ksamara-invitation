<?php

use App\Enums\UserRole;
use App\Models\User;

test('admin login redirects to admin dashboard', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->post(route('login.store'), [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
});

test('customer login redirects to customer dashboard', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $response = $this->post(route('login.store'), [
        'email' => $customer->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));
});

test('customer cannot access admin routes', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $response = $this->actingAs($customer)->get(route('admin.dashboard'));

    $response->assertForbidden();
});

test('admin can access admin routes', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
});

test('guest is redirected to login when accessing admin routes', function () {
    $response = $this->get(route('admin.dashboard'));

    $response->assertRedirect(route('login'));
});
