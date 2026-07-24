<?php

use App\Enums\UserRole;
use App\Models\User;

test('admin layout renders success, error, and warning flash messages', function () {
    $admin = User::factory()->create(['role' => UserRole::Admin]);

    $this->actingAs($admin)
        ->withSession(['success' => 'Berhasil disimpan.'])
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Berhasil disimpan.');

    $this->actingAs($admin)
        ->withSession(['error' => 'Terjadi kesalahan.'])
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Terjadi kesalahan.');

    $this->actingAs($admin)
        ->withSession(['warning' => 'Perhatian, data belum lengkap.'])
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Perhatian, data belum lengkap.');
});

test('flux initializes before the flash message toast listener', function (UserRole $role, string $route_name) {
    $user = User::factory()->create(['role' => $role]);

    $response = $this->actingAs($user)
        ->withSession(['success' => 'Berhasil disimpan.'])
        ->get(route($route_name));

    $response->assertOk()
        ->assertSee("addEventListener('alpine:initialized'", false)
        ->assertDontSee("addEventListener('alpine:init'", false)
        ->assertDontSee("addEventListener('DOMContentLoaded'", false);

    $html = $response->getContent();
    $flux_script_position = strpos($html, '/flux/flux');
    $toast_listener_position = strpos($html, "addEventListener('alpine:initialized'");

    expect($flux_script_position)->toBeInt()
        ->and($toast_listener_position)->toBeInt()
        ->and($flux_script_position)->toBeLessThan($toast_listener_position);
})->with([
    'admin layout' => [UserRole::Admin, 'admin.dashboard'],
    'customer layout' => [UserRole::Customer, 'dashboard'],
]);

test('customer layout renders success, error, and warning flash messages', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)
        ->withSession(['success' => 'Berhasil disimpan.'])
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Berhasil disimpan.');

    $this->actingAs($customer)
        ->withSession(['error' => 'Terjadi kesalahan.'])
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Terjadi kesalahan.');

    $this->actingAs($customer)
        ->withSession(['warning' => 'Perhatian, data belum lengkap.'])
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Perhatian, data belum lengkap.');
});
