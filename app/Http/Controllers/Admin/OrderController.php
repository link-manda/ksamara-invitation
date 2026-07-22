<?php

namespace App\Http\Controllers\Admin;

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

        return redirect()->back()->with('toast', 'Status pesanan berhasil diubah menjadi Lunas!');
    }
}
