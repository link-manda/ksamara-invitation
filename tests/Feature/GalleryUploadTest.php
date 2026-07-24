<?php

use App\Models\Gallery;
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

it('deletes an owned gallery file and returns to the gallery tab', function () {
    Storage::fake('public');

    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);
    $gallery = Gallery::factory()->create([
        'invitation_id' => $invitation->id,
        'file_path' => 'galleries/photo.jpg',
    ]);
    Storage::disk('public')->put($gallery->file_path, 'image');

    $this->actingAs($customer)
        ->delete(route('customer.invitations.galleries.destroy', [$invitation, $gallery]))
        ->assertRedirect(route('customer.invitations.edit', [
            'id' => $invitation->id,
            'tab' => 'galeri',
        ]))
        ->assertSessionHas('success');

    $this->assertDatabaseMissing('galleries', ['id' => $gallery->id]);
    Storage::disk('public')->assertMissing($gallery->file_path);
});

it('forbids deleting a gallery owned by another customer', function () {
    Storage::fake('public');

    $owner = User::factory()->create(['role' => 'customer']);
    $other_customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $owner->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $owner->id]),
    ]);
    $gallery = Gallery::factory()->create(['invitation_id' => $invitation->id]);
    Storage::disk('public')->put($gallery->file_path, 'image');

    $this->actingAs($other_customer)
        ->delete(route('customer.invitations.galleries.destroy', [$invitation, $gallery]))
        ->assertForbidden();

    $this->assertDatabaseHas('galleries', ['id' => $gallery->id]);
    Storage::disk('public')->assertExists($gallery->file_path);
});

it('does not delete a gallery through an unrelated invitation', function () {
    Storage::fake('public');

    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);
    $other_invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);
    $gallery = Gallery::factory()->create(['invitation_id' => $other_invitation->id]);
    Storage::disk('public')->put($gallery->file_path, 'image');

    $this->actingAs($customer)
        ->delete(route('customer.invitations.galleries.destroy', [$invitation, $gallery]))
        ->assertNotFound();

    $this->assertDatabaseHas('galleries', ['id' => $gallery->id]);
    Storage::disk('public')->assertExists($gallery->file_path);
});

it('prevents deleting a gallery before payment is completed', function () {
    Storage::fake('public');

    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->create(['user_id' => $customer->id]),
    ]);
    $gallery = Gallery::factory()->create(['invitation_id' => $invitation->id]);
    Storage::disk('public')->put($gallery->file_path, 'image');

    $this->actingAs($customer)
        ->delete(route('customer.invitations.galleries.destroy', [$invitation, $gallery]))
        ->assertRedirect(route('customer.orders.index'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('galleries', ['id' => $gallery->id]);
    Storage::disk('public')->assertExists($gallery->file_path);
});

it('renders delete controls for stored gallery images', function () {
    $customer = User::factory()->create(['role' => 'customer']);
    $invitation = Invitation::factory()->create([
        'user_id' => $customer->id,
        'order_id' => Order::factory()->paid()->create(['user_id' => $customer->id]),
    ]);
    $gallery = Gallery::factory()->create(['invitation_id' => $invitation->id]);

    $this->actingAs($customer)
        ->get(route('customer.invitations.edit', ['id' => $invitation->id, 'tab' => 'galeri']))
        ->assertOk()
        ->assertSee('Hapus foto galeri')
        ->assertSee(route('customer.invitations.galleries.destroy', [$invitation, $gallery]), false)
        ->assertSee("tab: 'galeri'", false);
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
