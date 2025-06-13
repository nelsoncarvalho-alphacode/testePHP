<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPedido extends Pivot
{
    use HasFactory;
    protected $table = 'item_pedido';
    protected $fillable = [
        'pedido_id',
        'produto_id', 
        'quantidade',
        'valor_unitario'
    ];

}
