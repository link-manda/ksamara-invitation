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
