<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = ['cliente_id', 'data_pedido', 'status'];
    protected $casts = [
        'data_pedido' => 'datetime'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
    
    public function produtos(): BelongsToMany
    {
        return $this->belongsToMany(Produto::class, 'item_pedido')
            ->using(ItemPedido::class)
            ->withPivot('quantidade', 'valor_unitario');
    }

    public function status(): Attribute
    {
        $inverse = array_flip(self::STATUS_LABELS);

        return Attribute::make(
            get: fn (mixed $value) => $inverse[$value] ?? $value,
            set: fn (mixed $label) => self::STATUS_LABELS[$label] ?? $label,
        );
    }

}
