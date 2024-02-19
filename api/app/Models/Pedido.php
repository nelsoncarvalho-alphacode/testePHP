<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        "produto_id",
        "quantidade_prod_pedido",
        "cliente_id",
    ];

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }

    public function cliente(){
        return $this->belongsTo('App\Models\Cliente');
    }
}
