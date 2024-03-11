<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseOrderItem;
use App\Models\Categorie;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'description',
        'price',
        'barcode',
        'status',
        'categorie_id',
    ];

    public function orderItens()
    {
        return $this->belongsTo(PurchaseOrderItem::class, 'product_id', 'id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }

    public static function getProductsForCategorie($categorieId)
    {
        return Product::whereNull('deleted_at')
            ->where('categorie_id', $categorieId)
            ->orderBy('name')
            ->get();
    }

    public static function getProducts($sort, $direction, $perPage, $categorieId)
    {
        $query = self::baseQuery($sort, $direction, $categorieId);

        return $query->whereNull('deleted_at')->paginate($perPage);
    }

    public static function getProductsDeleted($sort, $direction, $perPage, $categorieId)
    {
        $query = self::baseQuery($sort, $direction, $categorieId);

        return $query->onlyTrashed()->paginate($perPage);
    }

    protected static function baseQuery($sort, $direction, $categorieId)
    {
        $columnsMap = [
            'id' => 'products.id',
            'nome' => 'products.name',
            'quantidade' => 'products.quantity',
            'status' => 'products.status',
        ];

        $column = $columnsMap[$sort] ?? 'products.id';

        return self::where('categorie_id', $categorieId)
            ->orderBy($column, $direction);
    }
}
