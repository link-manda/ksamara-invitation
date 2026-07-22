<?php

namespace App\Services;

use App\Models\Invitation;
use App\Repositories\DigitalEnvelopeRepository;
use Illuminate\Http\UploadedFile;

class DigitalEnvelopeService
{
    public function __construct(private readonly DigitalEnvelopeRepository $repository) {}

    public function syncEnvelopes(Invitation $invitation, array $envelopesData): void
    {
        $keepIds = [];
        foreach ($envelopesData as $data) {
            $data['invitation_id'] = $invitation->id;

            if (isset($data['qr_code_file']) && $data['qr_code_file'] instanceof UploadedFile) {
                $data['qr_code_path'] = $data['qr_code_file']->store('qr_codes', 'public');
            }

            $env = $this->repository->updateOrCreateForInvitation($invitation, $data);
            $keepIds[] = $env->id;
        }
        $this->repository->deleteNotInIds($invitation, $keepIds);
    }
}
