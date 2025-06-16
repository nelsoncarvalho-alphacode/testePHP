<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaga extends Model {
    use SoftDeletes;
    
    public function candidatos(): BelongsToMany
    {
        return $this->belongsToMany(Candidato::class, 'candidato_vaga');
    }
}