<?php

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('prevents IDOR on editing invitation', function () {
    $customerA = User::factory()->create(['role' => 'customer']);
    $customerB = User::factory()->create(['role' => 'customer']);

    $invitationA = Invitation::factory()->create([
        'user_id' => $customerA->id,
    ]);

    $this->actingAs($customerB)
        ->get(route('customer.invitations.edit', $invitationA->id))
        ->assertForbidden();

    $this->actingAs($customerB)
        ->put(route('customer.invitations.update', $invitationA->id), [
            'title' => 'Hacked Title',
        ])
        ->assertForbidden();
});

it('prevents IDOR on fetching RSVPs', function () {
    $customerA = User::factory()->create(['role' => 'customer']);
    $customerB = User::factory()->create(['role' => 'customer']);

    $invitationA = Invitation::factory()->create([
        'user_id' => $customerA->id,
    ]);

    $this->actingAs($customerB)
        ->get(route('customer.invitations.rsvps.index', $invitationA->id))
        ->assertForbidden();
});
