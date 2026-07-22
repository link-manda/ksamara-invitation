<?php

namespace App\Repositories;

use App\Models\DigitalEnvelope;
use App\Models\Invitation;

class DigitalEnvelopeRepository
{
    public function updateOrCreateForInvitation(Invitation $invitation, array $data): DigitalEnvelope
    {
        return $invitation->digitalEnvelopes()->updateOrCreate(
            ['id' => $data['id'] ?? null],
            $data
        );
    }

    public function deleteNotInIds(Invitation $invitation, array $keepIds): void
    {
        $invitation->digitalEnvelopes()->whereNotIn('id', $keepIds)->delete();
    }
}
