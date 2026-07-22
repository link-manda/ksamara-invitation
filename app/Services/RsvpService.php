<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\Rsvp;
use App\Repositories\RsvpRepository;

class RsvpService
{
    public function __construct(private readonly RsvpRepository $repository) {}

    public function submitRsvp(Invitation $invitation, array $data): Rsvp
    {
        $data['invitation_id'] = $invitation->id;

        return $this->repository->create($data);
    }
}
