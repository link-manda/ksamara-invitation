<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly OrderRepository $orderRepository) {}

    public function index(Request $request): View
    {
        $orders = $this->orderRepository->getByUserId($request->user()->id);

        return view('customer.order.order_index', compact('orders'));
    }
}
