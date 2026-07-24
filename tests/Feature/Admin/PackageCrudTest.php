<?php

use App\Enums\UserRole;
use App\Models\Package;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRole::Admin]);
});

test('customer cannot access package management', function () {
    $customer = User::factory()->create(['role' => UserRole::Customer]);

    $this->actingAs($customer)->get(route('admin.packages.index'))->assertForbidden();
});

test('admin can view package list', function () {
    Package::factory()->count(2)->create();

    $this->actingAs($this->admin)
        ->get(route('admin.packages.index'))
        ->assertOk();
});

test('admin can view inactive packages', function () {
    $package = Package::factory()->create([
        'name' => 'Paket Nonaktif',
        'is_active' => false,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.packages.index'))
        ->assertOk()
        ->assertSee($package->name);
});

test('admin can create a package', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.packages.store'), [
        'name' => 'Gold',
        'price' => 500000,
        'features' => "QR Code\nUnlimited Guests",
        'is_active' => '1',
        'max_photos' => 20,
    ]);

    $response->assertRedirect(route('admin.packages.index'));

    $this->assertDatabaseHas('packages', [
        'name' => 'Gold',
        'price' => 500000,
        'is_active' => true,
    ]);
});

test('creating a package requires a name', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.packages.store'), ['price' => 100000])
        ->assertInvalid(['name']);
});

test('admin can update a package', function () {
    $package = Package::factory()->create(['name' => 'Basic']);

    $response = $this->actingAs($this->admin)->put(route('admin.packages.update', $package), [
        'name' => 'Basic Plus',
        'price' => $package->price,
        'features' => '',
        'is_active' => '0',
        'max_photos' => 10,
    ]);

    $response->assertRedirect(route('admin.packages.index'));

    expect($package->refresh())
        ->name->toBe('Basic Plus')
        ->is_active->toBeFalse();
});

test('admin can delete a package', function () {
    $package = Package::factory()->create();

    $this->actingAs($this->admin)
        ->delete(route('admin.packages.destroy', $package))
        ->assertRedirect(route('admin.packages.index'));

    $this->assertDatabaseMissing('packages', ['id' => $package->id]);
});
