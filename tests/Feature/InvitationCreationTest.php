<?php

use App\Enums\InvitationStatus;
use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\Template;
use App\Models\User;
use App\Services\InvitationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

beforeEach(function () {
    $this->customer = User::factory()->create(['role' => UserRole::Customer]);
    $this->template = Template::factory()->create(['is_active' => true]);
});

test('invitation creation form only displays active packages', function () {
    $active_package = Package::factory()->create([
        'name' => 'Paket Aktif',
        'is_active' => true,
    ]);
    $inactive_package = Package::factory()->create([
        'name' => 'Paket Nonaktif',
        'is_active' => false,
    ]);

    $this->actingAs($this->customer)
        ->get(route('customer.invitations.create'))
        ->assertOk()
        ->assertSee($active_package->name)
        ->assertDontSee($inactive_package->name);
});

test('inactive package cannot be used to create an invitation', function () {
    $inactive_package = Package::factory()->create(['is_active' => false]);

    $this->actingAs($this->customer)
        ->post(route('customer.invitations.store'), [
            'package_id' => $inactive_package->id,
            'template_id' => $this->template->id,
            'slug' => 'romeo-juliet',
            'groom_name' => 'Romeo',
            'bride_name' => 'Juliet',
        ])
        ->assertInvalid(['package_id']);

    $this->assertDatabaseMissing('orders', [
        'user_id' => $this->customer->id,
        'package_id' => $inactive_package->id,
    ]);
    $this->assertDatabaseMissing('invitations', ['user_id' => $this->customer->id]);
});

test('invitation service rejects an inactive package without writing data', function () {
    $inactive_package = Package::factory()->create(['is_active' => false]);

    expect(fn () => app(InvitationService::class)->createInvitationAndOrder($this->customer, [
        'package_id' => $inactive_package->id,
        'template_id' => $this->template->id,
        'slug' => 'service-guard',
        'groom_name' => 'Romeo',
        'bride_name' => 'Juliet',
    ]))->toThrow(ModelNotFoundException::class);

    $this->assertDatabaseMissing('orders', [
        'user_id' => $this->customer->id,
        'package_id' => $inactive_package->id,
    ]);
    $this->assertDatabaseMissing('invitations', ['user_id' => $this->customer->id]);
});

test('active package creates a pending order and draft invitation', function () {
    $active_package = Package::factory()->create([
        'price' => 250_000,
        'is_active' => true,
    ]);

    $this->actingAs($this->customer)
        ->post(route('customer.invitations.store'), [
            'package_id' => $active_package->id,
            'template_id' => $this->template->id,
            'slug' => 'romeo-juliet',
            'groom_name' => 'Romeo',
            'bride_name' => 'Juliet',
        ])
        ->assertRedirect(route('dashboard'));

    $order = Order::query()->where('user_id', $this->customer->id)->sole();

    expect($order)
        ->package_id->toBe($active_package->id)
        ->amount->toBe($active_package->price)
        ->status->toBe(OrderStatus::Pending);

    $invitation = Invitation::query()->where('user_id', $this->customer->id)->sole();

    expect($invitation)
        ->order_id->toBe($order->id)
        ->template_id->toBe($this->template->id)
        ->slug->toBe('romeo-juliet')
        ->status->toBe(InvitationStatus::Draft);
});
