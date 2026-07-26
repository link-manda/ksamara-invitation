<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(private readonly OrderRepository $repository) {}

    public function markAsPaid(int $orderId): bool
    {
        return $this->repository->markPendingAsPaid($orderId);
    }
}
