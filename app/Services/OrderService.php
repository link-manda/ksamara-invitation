<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(private readonly OrderRepository $repository) {}

    public function markAsPaid(Order $order): bool
    {
        return $this->repository->update($order, ['status' => OrderStatus::Paid]);
    }
}
