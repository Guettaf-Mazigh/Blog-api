<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->role === 'admin';
    }

    public function update(User $user, User $model): bool{
        return $user->id === $model->id || $user->role === 'admin';
    }

    public function view(User $user, User $model): bool{
        return $user->id === $model->id || $user->role === 'admin';
    }

    public function viewAny(User $user): bool{
        return $user->role === 'admin';
    }
}
