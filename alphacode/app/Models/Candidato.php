<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = [
    'nome',
    'email',
    'telefone',
    'curriculo',
];

public function vagas()
{
    return $this->belongsToMany(Vaga::class, 'candidato_vaga');
}

}
