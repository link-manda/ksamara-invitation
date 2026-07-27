<?php

use App\Models\Package;
use App\Models\Template;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->customer = User::factory()->create(['role' => 'customer', 'email_verified_at' => now()]);

    $this->packageSilver = Package::factory()->create(['name' => 'Silver', 'is_active' => true]);
    $this->packageGold = Package::factory()->create(['name' => 'Gold', 'is_active' => true]);
});

test('admin can assign specific packages when creating a template', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.templates.store'), [
        'name' => 'Template Silver Exclusive',
        'view_path' => 'themes.silver_exclusive',
        'is_active' => 1,
        'packages' => [$this->packageSilver->id],
    ]);

    $response->assertRedirect(route('admin.templates.index'));

    $template = Template::where('name', 'Template Silver Exclusive')->first();
    expect($template)->not->toBeNull();
    expect($template->packages->pluck('id')->toArray())->toContain($this->packageSilver->id);
    expect($template->packages->pluck('id')->toArray())->not->toContain($this->packageGold->id);
});

test('customer cannot use a template restricted to another package', function () {
    $templateGold = Template::factory()->create(['name' => 'Template Gold Only', 'is_active' => true]);
    $templateGold->packages()->sync([$this->packageGold->id]);

    $response = $this->actingAs($this->customer)->post(route('customer.invitations.store'), [
        'package_id' => $this->packageSilver->id,
        'template_id' => $templateGold->id,
        'slug' => 'test-slug-unauthorized',
        'groom_name' => 'Romeo',
        'bride_name' => 'Juliet',
    ]);

    $response->assertSessionHasErrors('template_id');
});

test('customer can use a template assigned to their chosen package or universal template', function () {
    $templateSilver = Template::factory()->create(['name' => 'Template Silver', 'is_active' => true]);
    $templateSilver->packages()->sync([$this->packageSilver->id]);

    $response = $this->actingAs($this->customer)->post(route('customer.invitations.store'), [
        'package_id' => $this->packageSilver->id,
        'template_id' => $templateSilver->id,
        'slug' => 'test-slug-authorized',
        'groom_name' => 'Romeo',
        'bride_name' => 'Juliet',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('invitations', ['slug' => 'test-slug-authorized']);
});
