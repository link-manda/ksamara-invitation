<?php

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->customer = User::factory()->create(['role' => UserRole::Customer]);
    $this->package = Package::factory()->create();
});

test('admin can mark a pending order as paid once', function () {
    $order = Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 500_000,
        'status' => OrderStatus::Pending,
    ]);

    $this->actingAs($this->admin)
        ->patch(route('admin.orders.mark-paid', $order->id))
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($order->refresh()->status)->toBe(OrderStatus::Paid);

    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertViewHas('stats', fn (array $stats): bool => $stats['pending_orders'] === 0
            && $stats['total_revenue'] === 500_000);
});

test('repeating paid transition returns a warning without changing the order', function () {
    $order = Order::factory()->paid()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 500_000,
    ]);
    $updated_at = $order->updated_at;

    $this->travel(1)->minutes();

    $this->actingAs($this->admin)
        ->patch(route('admin.orders.mark-paid', $order->id))
        ->assertRedirect()
        ->assertSessionHas('warning')
        ->assertSessionMissing('success');

    expect($order->refresh())
        ->status->toBe(OrderStatus::Paid)
        ->updated_at->toEqual($updated_at);
});

test('marking a missing order as paid returns not found', function () {
    $this->actingAs($this->admin)
        ->patch(route('admin.orders.mark-paid', 999_999))
        ->assertNotFound();
});

test('customer cannot mark an order as paid', function () {
    $order = Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
    ]);

    $this->actingAs($this->customer)
        ->patch(route('admin.orders.mark-paid', $order->id))
        ->assertForbidden();

    expect($order->refresh()->status)->toBe(OrderStatus::Pending);
});

test('order index opens the shared paid confirmation instead of submitting directly', function () {
    $order = Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 500_000,
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));

    $response->assertOk()
        ->assertSee('open-paid-confirmation', false)
        ->assertSee('confirm-paid-modal', false)
        ->assertSee('Rp 500.000')
        ->assertDontSee('<form action="'.route('admin.orders.mark-paid', $order->id).'"', false);
});
