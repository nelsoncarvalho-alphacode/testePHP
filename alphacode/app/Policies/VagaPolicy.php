<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vaga;
use Illuminate\Auth\Access\Response;

class VagaPolicy
{
    public function before(User $user, string $ability)
    {
        if (!$user->candidato) {
            return true; 
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vaga $vaga): bool
    {

        return true;
    }

    public function create(User $user): bool
    {
        return !$user->candidato; 
    }

    public function update(User $user, Vaga $vaga): bool
    {
        return !$user->candidato; 
    }

    public function delete(User $user, Vaga $vaga): bool
    {
        return !$user->candidato; 
    }

    public function restore(User $user, Vaga $vaga): bool
    {
        return !$user->candidato;
    }

    public function forceDelete(User $user, Vaga $vaga): bool
    {
        return !$user->candidato;
    }
}
