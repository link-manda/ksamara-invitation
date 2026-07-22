<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    public function findById(int $id): ?Order
    {
        return Order::find($id);
    }

    public function findByXenditInvoiceId(string $invoiceId): ?Order
    {
        return Order::where('xendit_invoice_id', $invoiceId)->first();
    }

    public function getByUserId(int $userId): Collection
    {
        return Order::with(['package', 'invitation'])->where('user_id', $userId)->latest()->get();
    }

    public function getAllOrders(): Collection
    {
        return Order::with(['user', 'package', 'invitation'])->latest()->get();
    }

    public function sumPaidAmount(): int
    {
        return (int) Order::where('status', OrderStatus::Paid)->sum('amount');
    }

    public function countPending(): int
    {
        return Order::where('status', OrderStatus::Pending)->count();
    }

    public function sumPendingAmountByUserId(int $userId): int
    {
        return (int) Order::where('user_id', $userId)
            ->where('status', OrderStatus::Pending)
            ->sum('amount');
    }
}
