<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable = [
    'user_id',
    'cpf',
    'telefone',
    'endereco',
    'formacao',
    'experiencia_profissional',
    'habilidades',
    'curriculo',
];

public function user() 
    {
        return $this->belongsTo(User::class);
    }

public function vagas()
{
    return $this->belongsToMany(Vaga::class, 'candidato_vaga');
}

}
