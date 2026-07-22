<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\Invitation;

class EventRepository
{
    public function updateOrCreateForInvitation(Invitation $invitation, array $eventData): Event
    {
        return $invitation->events()->updateOrCreate(
            ['id' => $eventData['id'] ?? null],
            $eventData
        );
    }

    public function deleteNotInIds(Invitation $invitation, array $keepIds): void
    {
        $invitation->events()->whereNotIn('id', $keepIds)->delete();
    }
}
