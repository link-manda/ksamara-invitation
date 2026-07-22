<?php

namespace App\Services;

use App\Enums\GalleryType;
use App\Models\Invitation;
use App\Repositories\GalleryRepository;
use Illuminate\Http\UploadedFile;

class GalleryService
{
    public function __construct(private readonly GalleryRepository $repository) {}

    public function uploadGalleries(Invitation $invitation, array $files): void
    {
        $package = $invitation->order->package;
        if ($package && $package->max_photos > 0) {
            $existingCount = $this->repository->countByInvitationId($invitation->id);
            if (($existingCount + count($files)) > $package->max_photos) {
                $max = $package->max_photos;
                throw new \Exception('Gagal mengunggah foto. Anda telah mencapai batas maksimal ' . $max . ' foto untuk paket ini.');
            }
        }

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                if (! $file->isValid()) {
                    throw new \Exception('File gambar rusak atau tidak terbaca server.');
                }

                // hashName() is automatically used by store()
                $path = $file->store('galleries/invitation_'.$invitation->id, 'public');
                if (! $path) {
                    throw new \Exception('Gagal menyimpan file gambar ke disk.');
                }

                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'video/') ? GalleryType::Video : GalleryType::Photo;

                $this->repository->create([
                    'invitation_id' => $invitation->id,
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }
    }
}
