<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrder;
use App\Models\Product;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'product_name',
        'unit_price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id', 'id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public static function createPurchaseOrderItems($purchaseOrderId, $productList)
    {
        foreach ($productList as $product) {
            PurchaseOrderItems::insert([
                'purchase_order_id' => $purchaseOrderId,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->price,
                'quantity' => $product->quantity
            ]);
        }
    }
}
