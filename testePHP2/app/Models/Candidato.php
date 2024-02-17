<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidatos';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'qtdExp',
        'linguagens',
        'formacao',
    ];

    public function vagas()
    {
        return $this->belongsToMany(Vaga::class);
    }
}
