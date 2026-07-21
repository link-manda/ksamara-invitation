<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class AuthService
{
    public function __construct(private readonly UserRepository $users) {}

    public function isAdmin(User $user): bool
    {
        return $this->users->isAdmin($user);
    }

    public function redirectPath(User $user): string
    {
        return $this->isAdmin($user) ? route('admin.dashboard') : route('dashboard');
    }
}
