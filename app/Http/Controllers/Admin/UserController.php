<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    public function index(): View
    {
        $users = $this->userService->getAllCustomers();

        return view('user.user_index', compact('users'));
    }

    public function create(): View
    {
        return view('user.user_form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $this->userService->createCustomer($validated);

        return NotificationHelper::redirectSuccess('admin.users.index', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $user = $this->userService->getCustomerById($id);

        return view('user.user_form', compact('user'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $user = $this->userService->getCustomerById($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $this->userService->updateCustomer($user, $validated);

        return NotificationHelper::redirectSuccess('admin.users.index', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $user = $this->userService->getCustomerById($id);
        $this->userService->deleteCustomer($user);

        return NotificationHelper::redirectSuccess('admin.users.index', 'Pelanggan berhasil dihapus!');
    }
}
