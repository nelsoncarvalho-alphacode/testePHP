<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Application;

class ApplicationPolicy
{
    public function view(User $user, Application $application): bool
    {
   
        if ($user->candidato) {
            return $user->candidato->id === $application->candidato_id;
        }

        return !$user->candidato;
    }

    public function update(User $user, Application $application): bool
    {
        return !$user->candidato;
    }
}