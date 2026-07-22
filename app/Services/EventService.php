<?php

namespace App\Services;

use App\Models\Invitation;
use App\Repositories\EventRepository;

class EventService
{
    public function __construct(private readonly EventRepository $repository) {}

    public function syncEvents(Invitation $invitation, array $eventsData): void
    {
        $keepIds = [];
        foreach ($eventsData as $eventData) {
            $eventData['invitation_id'] = $invitation->id;
            $event = $this->repository->updateOrCreateForInvitation($invitation, $eventData);
            $keepIds[] = $event->id;
        }
        $this->repository->deleteNotInIds($invitation, $keepIds);
    }
}
