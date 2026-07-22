<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardService $dashboardService) {}

    public function index(Request $request): View
    {
        $invitations = $request->user()->invitations()->latest()->get();
        $has_invitation = $invitations->isNotEmpty();
        $stats = $this->dashboardService->getCustomerStats($request->user()->id);

        return view('customer.customer_dashboard', compact('invitations', 'has_invitation', 'stats'));
    }
}
