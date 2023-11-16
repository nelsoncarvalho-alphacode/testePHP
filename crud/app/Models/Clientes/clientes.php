<?php

namespace App\Models\Clientes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'senha'
    ];
}
