<?php

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Invitation;
use App\Models\Order;
use App\Models\Package;
use App\Models\Template;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRole::Admin]);
    $this->customer = User::factory()->create(['role' => UserRole::Customer]);
    $this->package = Package::factory()->create(['is_active' => true]);
});

test('admin dashboard reports accurate operational statistics', function () {
    User::factory()->create(['role' => UserRole::Customer]);
    User::factory()->create(['role' => UserRole::Admin]);

    $active_template = Template::factory()->create(['is_active' => true]);
    Package::factory()->create(['is_active' => false]);
    Template::factory()->create(['is_active' => false]);

    $paid_order = Order::factory()->paid()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 500_000,
    ]);
    Order::factory()->paid()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 250_000,
    ]);
    Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 300_000,
        'status' => OrderStatus::Pending,
    ]);
    Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'amount' => 900_000,
        'status' => OrderStatus::Failed,
    ]);

    Invitation::factory()->create([
        'user_id' => $this->customer->id,
        'order_id' => $paid_order->id,
        'template_id' => $active_template->id,
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertViewHas('stats', function (array $stats): bool {
            return $stats['total_customers'] === 2
                && $stats['total_invitations'] === 1
                && $stats['total_revenue'] === 750_000
                && $stats['pending_orders'] === 1
                && $stats['pending_amount'] === 300_000
                && $stats['total_packages'] === 1
                && $stats['total_templates'] === 1;
        });
});

test('admin dashboard queues only five oldest pending orders', function () {
    $pending_orders = collect(range(1, 6))->map(function (int $position): Order {
        return Order::factory()->create([
            'user_id' => $this->customer->id,
            'package_id' => $this->package->id,
            'amount' => $position * 100_000,
            'status' => OrderStatus::Pending,
            'created_at' => now()->subDays(7 - $position),
        ]);
    });

    $paid_order = Order::factory()->paid()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'created_at' => now()->subDays(10),
    ]);
    $failed_order = Order::factory()->create([
        'user_id' => $this->customer->id,
        'package_id' => $this->package->id,
        'status' => OrderStatus::Failed,
        'created_at' => now()->subDays(9),
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertViewHas('stats', function (array $stats) use ($pending_orders): bool {
            return $stats['pending_orders_queue']->pluck('id')->all() === $pending_orders->take(5)->pluck('id')->all();
        })
        ->assertDontSee('#ORD-'.str_pad((string) $paid_order->id, 5, '0', STR_PAD_LEFT))
        ->assertDontSee('#ORD-'.str_pad((string) $failed_order->id, 5, '0', STR_PAD_LEFT));
});

test('admin dashboard replaces hardcoded health claims with content readiness', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Kesiapan Konten')
        ->assertDontSee('Semua Layanan Berjalan Normal')
        ->assertDontSee('WhatsApp CS Terhubung');
});

test('admin dashboard shows an actionable empty pending queue', function () {
    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Tidak ada pembayaran yang perlu diverifikasi.');
});

test('paid confirmation modal renders before Flux scripts', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('open-paid-confirmation', false)
        ->assertSee("\$dispatch('modal-show'", false);

    $html = $response->getContent();
    $modal_position = strpos($html, 'data-modal="confirm-paid-modal"');
    $flux_script_position = strpos($html, '/flux/flux');

    expect($modal_position)->toBeInt()
        ->and($flux_script_position)->toBeInt()
        ->and($modal_position)->toBeLessThan($flux_script_position);
});
