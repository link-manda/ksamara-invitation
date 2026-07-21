<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\User;

class UserRepository
{
    public function isAdmin(User $user): bool
    {
        return $user->role === UserRole::Admin;
    }
}
