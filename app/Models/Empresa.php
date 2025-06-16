<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class);
    }
}
