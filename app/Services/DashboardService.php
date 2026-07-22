<?php

namespace App\Services;

use App\Repositories\InvitationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RsvpRepository;
use App\Repositories\UserRepository;

class DashboardService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly InvitationRepository $invitationRepository,
        private readonly OrderRepository $orderRepository,
        private readonly RsvpRepository $rsvpRepository
    ) {}

    public function getAdminStats(): array
    {
        return [
            'total_customers' => $this->userRepository->countCustomers(),
            'total_invitations' => $this->invitationRepository->countAll(),
            'total_revenue' => $this->orderRepository->sumPaidAmount(),
            'pending_orders' => $this->orderRepository->countPending(),
        ];
    }

    public function getCustomerStats(int $userId): array
    {
        $invitationIds = $this->invitationRepository->pluckIdsByUserId($userId);

        return [
            'total_invitations' => count($invitationIds),
            'total_guests' => $this->rsvpRepository->sumHadirByInvitationIds($invitationIds),
            'unpaid_bills' => $this->orderRepository->sumPendingAmountByUserId($userId),
        ];
    }
}
