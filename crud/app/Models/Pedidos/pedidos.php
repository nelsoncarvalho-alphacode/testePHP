<?php

namespace App\Models\Pedidos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedidos extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_do_pedido',
        'cliente_id',
        'status',
        'produto_id',
        'quantidade',
    ];
}
