<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['barcode', 'product_name', 'unit_price'];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
