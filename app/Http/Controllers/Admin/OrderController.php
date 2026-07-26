<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly OrderService $orderService
    ) {}

    public function index(): View
    {
        $orders = $this->orderRepository->getAllOrders();

        return view('admin.order.order_index', compact('orders'));
    }

    public function markAsPaid(int $id): RedirectResponse
    {
        $this->orderRepository->findOrFail($id);

        if (! $this->orderService->markAsPaid($id)) {
            return NotificationHelper::backWithWarning('Pesanan sudah diproses dan tidak dapat ditandai ulang.');
        }

        return NotificationHelper::backWithSuccess('Status pesanan berhasil diubah menjadi Lunas!');
    }
}
