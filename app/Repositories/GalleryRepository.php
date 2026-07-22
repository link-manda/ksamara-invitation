<?php

namespace App\Repositories;

use App\Models\Gallery;

class GalleryRepository
{
    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function getByInvitationId(int $invitationId)
    {
        return Gallery::where('invitation_id', $invitationId)->get();
    }

    public function countByInvitationId(int $invitationId): int
    {
        return Gallery::where('invitation_id', $invitationId)->count();
    }
}
