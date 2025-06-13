<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['cod_barras', 'nome', 'valor_unitario'];
    
    public function pedidos(): BelongsToMany
    {
        return $this->belongsToMany(Pedido::class, 'item_pedido')
            ->withPivot('quantidade', 'valor_unitario');
    }
}
