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
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                // hashName() is automatically used by store()
                $path = $file->store('galleries', 'public');

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
