<?php

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('blocks public access when invitation status is draft', function () {
    $template = Template::factory()->create(['view_path' => 'bali_classic']);
    $invitation = Invitation::factory()->create([
        'template_id' => $template->id,
        'slug' => 'draft-wedding',
        'status' => InvitationStatus::Draft,
    ]);

    $response = $this->get(route('public.invitation.show', $invitation->slug));

    $response->assertStatus(403);
});

it('blocks public access when invitation status is inactive', function () {
    $template = Template::factory()->create(['view_path' => 'bali_classic']);
    $invitation = Invitation::factory()->create([
        'template_id' => $template->id,
        'slug' => 'inactive-wedding',
        'status' => InvitationStatus::Inactive,
    ]);

    $response = $this->get(route('public.invitation.show', $invitation->slug));

    $response->assertStatus(403);
});

it('allows public access when invitation status is published', function () {
    $template = Template::factory()->create(['view_path' => 'bali_classic']);
    $invitation = Invitation::factory()->create([
        'template_id' => $template->id,
        'slug' => 'published-wedding',
        'status' => InvitationStatus::Published,
    ]);

    $response = $this->get(route('public.invitation.show', $invitation->slug));

    $response->assertStatus(200);
});

it('blocks RSVP submission when invitation is not published', function () {
    $template = Template::factory()->create(['view_path' => 'bali_classic']);
    $invitation = Invitation::factory()->create([
        'template_id' => $template->id,
        'slug' => 'unpublished-wedding',
        'status' => InvitationStatus::Inactive,
    ]);

    $response = $this->post(route('public.invitation.rsvp', $invitation->slug), [
        'guest_name' => 'John Doe',
        'status' => 'hadir',
        'guest_count' => 2,
        'message' => 'Selamat ya!',
    ]);

    $response->assertStatus(403);
});
