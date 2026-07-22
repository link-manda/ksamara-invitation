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
                if (! $data['qr_code_file']->isValid()) {
                    throw new \Exception('File QR Code rusak atau tidak terbaca server.');
                }

                $path = $data['qr_code_file']->store('qr_codes', 'public');
                if (! $path) {
                    throw new \Exception('Gagal menyimpan QR Code ke disk.');
                }
                $data['qr_code_path'] = $path;
            }

            $env = $this->repository->updateOrCreateForInvitation($invitation, $data);
            $keepIds[] = $env->id;
        }
        $this->repository->deleteNotInIds($invitation, $keepIds);
    }
}
