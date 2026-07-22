<?php

namespace App\Repositories;

use App\Models\Rsvp;

class RsvpRepository
{
    public function create(array $data): Rsvp
    {
        return Rsvp::create($data);
    }
}
