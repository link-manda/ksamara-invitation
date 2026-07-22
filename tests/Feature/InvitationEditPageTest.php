<?php

use App\Models\Invitation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders the invitation edit page for its owner without errors', function () {
    $customer = User::factory()->create(['role' => 'customer']);

    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);

    $this->actingAs($customer)
        ->get(route('customer.invitations.edit', $invitation->id))
        ->assertOk()
        ->assertSee('Manajemen Detail Undangan')
        ->assertSee('Rangkaian Acara');
});
