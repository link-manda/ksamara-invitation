<?php

use App\Models\Package;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

test('landing page only displays active packages', function () {
    $active_package = Package::factory()->create([
        'name' => 'Paket Aktif',
        'is_active' => true,
    ]);
    $inactive_package = Package::factory()->create([
        'name' => 'Paket Nonaktif',
        'is_active' => false,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee($active_package->name)
        ->assertDontSee($inactive_package->name);
});
