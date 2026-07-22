<?php

use App\Enums\InvitationStatus;
use App\Models\Invitation;
use App\Models\Template;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throttles excessive rsvp submissions', function () {
    $template = Template::factory()->create();

    $invitation = Invitation::factory()->create([
        'template_id' => $template->id,
        'slug' => 'test-invitation',
        'status' => InvitationStatus::Published,
    ]);

    $url = route('public.invitation.rsvp', ['slug' => 'test-invitation']);

    for ($i = 0; $i < 5; $i++) {
        $response = $this->post($url, [
            'name' => 'Guest '.$i,
            'guest_count' => 1,
            'status' => 'hadir',
        ]);
        $response->assertStatus(302);
    }

    $response = $this->post($url, [
        'name' => 'Spammer',
        'guest_count' => 1,
        'status' => 'hadir',
    ]);

    $response->assertStatus(429);
});
