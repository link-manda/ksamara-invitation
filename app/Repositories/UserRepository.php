<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function countCustomers(): int
    {
        return User::where('role', 'customer')->count();
    }

    public function isAdmin(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function getAllCustomers(): Collection
    {
        return User::where('role', UserRole::Customer)->latest()->get();
    }

    public function findById(int $id): ?User
    {
        return User::findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
