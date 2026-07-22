<?php

use App\Models\Invitation;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('uploads gallery files and persists them when updating an invitation', function () {
    Storage::fake('public');

    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);

    $file = UploadedFile::fake()->image('photo.jpg');

    $this->actingAs($customer)
        ->put(route('customer.invitations.update', $invitation->id), [
            'title' => 'Pernikahan A & B',
            'groom_name' => 'A',
            'bride_name' => 'B',
            'galleries' => [$file],
        ])
        ->assertRedirect();

    expect($invitation->galleries()->count())->toBe(1);

    $path = $invitation->galleries()->first()->file_path;
    Storage::disk('public')->assertExists($path);
});

it('allows saving invitation details with empty parent names', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
        'groom_parents' => 'Existing',
        'bride_parents' => 'Existing',
    ]);

    $this->actingAs($customer)
        ->put(route('customer.invitations.update', $invitation->id), [
            'title' => 'Pernikahan A & B',
            'groom_name' => 'A',
            'bride_name' => 'B',
            'groom_parents' => '',
            'bride_parents' => '',
        ])
        ->assertRedirect();

    expect($invitation->fresh()->groom_parents)->toBeNull();
});
