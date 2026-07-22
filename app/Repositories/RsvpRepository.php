<?php

namespace App\Repositories;

use App\Enums\RsvpStatus;
use App\Models\Rsvp;
use Illuminate\Database\Eloquent\Collection;

class RsvpRepository
{
    public function create(array $data): Rsvp
    {
        return Rsvp::create($data);
    }

    public function getByInvitationId(int $invitationId): Collection
    {
        return Rsvp::where('invitation_id', $invitationId)->latest()->get();
    }

    public function sumHadirByInvitationIds(array $invitationIds): int
    {
        return (int) Rsvp::whereIn('invitation_id', $invitationIds)
            ->where('status', RsvpStatus::Hadir)
            ->sum('guest_count');
    }
}
