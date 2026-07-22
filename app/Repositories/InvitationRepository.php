<?php

namespace App\Repositories;

use App\Models\Invitation;

class InvitationRepository
{
    public function create(array $data): Invitation
    {
        return Invitation::create($data);
    }

    public function update(Invitation $invitation, array $data): bool
    {
        return $invitation->update($data);
    }

    public function findBySlugWithRelations(string $slug): ?Invitation
    {
        return Invitation::with([
            'template',
            'events',
            'galleries',
            'digitalEnvelopes',
            'rsvps' => function ($query) {
                $query->latest();
            },
        ])->where('slug', $slug)->first();
    }

    public function countAll(): int
    {
        return Invitation::count();
    }

    public function countByUserId(int $userId): int
    {
        return Invitation::where('user_id', $userId)->count();
    }

    public function pluckIdsByUserId(int $userId): array
    {
        return Invitation::where('user_id', $userId)->pluck('id')->toArray();
    }
}
