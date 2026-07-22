<?php

namespace App\Services;

use App\Enums\InvitationStatus;
use App\Enums\OrderStatus;
use App\Models\Invitation;
use App\Models\User;
use App\Repositories\InvitationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PackageRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvitationService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly InvitationRepository $invitationRepository,
        private readonly PackageRepository $packageRepository
    ) {}

    public function createInvitationAndOrder(User $user, array $data): Invitation
    {
        return DB::transaction(function () use ($user, $data) {
            $package = $this->packageRepository->getById((int) $data['package_id']);

            $order = $this->orderRepository->create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'amount' => $package->price,
                'status' => OrderStatus::Pending,
            ]);

            $title = 'Pernikahan '.$data['groom_name'].' & '.$data['bride_name'];

            $invitation = $this->invitationRepository->create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'template_id' => $data['template_id'],
                'slug' => $data['slug'],
                'title' => $title,
                'groom_name' => $data['groom_name'],
                'bride_name' => $data['bride_name'],
                'groom_parents' => '',
                'bride_parents' => '',
                'status' => InvitationStatus::Draft,
            ]);

            return $invitation;
        });
    }

    public function updateInvitation(Invitation $invitation, array $data): bool
    {
        return $this->invitationRepository->update($invitation, $data);
    }

    public function toggleStatus(Invitation $invitation): bool
    {
        $newStatus = match ($invitation->status) {
            InvitationStatus::Draft => InvitationStatus::Published,
            InvitationStatus::Published => InvitationStatus::Inactive,
            InvitationStatus::Inactive => InvitationStatus::Published,
        };

        return $this->invitationRepository->update($invitation, ['status' => $newStatus]);
    }

    public function deleteInvitation(Invitation $invitation): bool
    {
        return DB::transaction(function () use ($invitation) {
            foreach ($invitation->galleries as $gallery) {
                if (Storage::disk('public')->exists($gallery->file_path)) {
                    Storage::disk('public')->delete($gallery->file_path);
                }
            }

            foreach ($invitation->digitalEnvelopes as $envelope) {
                if ($envelope->qr_code_path && Storage::disk('public')->exists($envelope->qr_code_path)) {
                    Storage::disk('public')->delete($envelope->qr_code_path);
                }
            }

            Storage::disk('public')->deleteDirectory('galleries/invitation_'.$invitation->id);

            return $this->invitationRepository->delete($invitation);
        });
    }
}
