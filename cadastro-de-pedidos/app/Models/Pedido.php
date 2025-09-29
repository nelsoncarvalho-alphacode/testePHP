<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'data_pedido',
        'status',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
