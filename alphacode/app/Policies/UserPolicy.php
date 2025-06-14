<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user, string $ability)
    {
        if (!$user->candidato == 'candidato') {
            return true; 
        }

        return null; 
    }

    public function viewAny(User $user): bool
    {
    
        return !$user->candidato;
    }

    public function view(User $user, User $model): bool
    {
        
        return !$user->candidato;
    }

    public function update(User $user, User $model): bool
    {
        return !$user->candidato && $user->id !== $model->id;
    }
}
