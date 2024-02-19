<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;
use App\Models\Cliente;

class Pedido extends Model
{
    use HasFactory;

    public function produto(){
        return $this->belongsTo(Produto::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
