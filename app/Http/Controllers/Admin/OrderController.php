<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $order = Order::findOrFail($id);

        $this->orderService->markAsPaid($order);

        return NotificationHelper::backWithSuccess('Status pesanan berhasil diubah menjadi Lunas!');
    }
}
