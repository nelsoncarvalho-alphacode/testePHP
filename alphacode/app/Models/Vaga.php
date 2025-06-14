<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'tipo_vaga', 
        'ativa',
    ];

    public function candidatos()
    {
        return $this->belongsToMany(Candidato::class, 'candidato_vaga')
                    ->withTimestamps();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
