<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Template;
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
            'recent_orders' => $this->orderRepository->getRecentOrders(5),
            'total_packages' => Package::where('is_active', true)->count(),
            'total_templates' => Template::where('is_active', true)->count(),
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
