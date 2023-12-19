<?php

namespace App\Models\Produtos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produtos extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo_barras',
        'nome',
        'quantidade',
        'valor_unitario',
    ];
}
