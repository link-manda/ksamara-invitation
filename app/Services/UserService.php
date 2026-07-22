<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private readonly UserRepository $repository) {}

    public function getAllCustomers(): Collection
    {
        return $this->repository->getAllCustomers();
    }

    public function getCustomerById(int $id): ?User
    {
        $user = $this->repository->findById($id);
        if ($user && $user->role !== UserRole::Customer) {
            abort(403, 'Anda hanya dapat mengelola data pelanggan.');
        }

        return $user;
    }

    public function createCustomer(array $data): User
    {
        $data['role'] = UserRole::Customer;

        if (empty($data['password'])) {
            $data['password'] = Hash::make('password123'); // Default password if empty
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repository->create($data);
    }

    public function updateCustomer(User $user, array $data): bool
    {
        if ($user->role !== UserRole::Customer) {
            abort(403, 'Anda hanya dapat mengelola data pelanggan.');
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->repository->update($user, $data);
    }

    public function deleteCustomer(User $user): bool
    {
        if ($user->role !== UserRole::Customer) {
            abort(403, 'Anda hanya dapat menghapus data pelanggan.');
        }

        return $this->repository->delete($user);
    }
}
