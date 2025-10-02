<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_barras',
        'nome',
        'valor_unitario',
    ];

    public function pedidoItens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
