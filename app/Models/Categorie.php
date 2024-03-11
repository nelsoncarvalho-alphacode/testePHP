<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'categorie_id', 'id');
    }

    public static function getCategories($includeDeleted = false)
    {
        return Categorie::whereHas('products', function ($query) use ($includeDeleted) {
                if ($includeDeleted) {
                    $query->onlyTrashed();
                } else {
                    $query->whereNull('deleted_at');
                }
            })->orderBy('name')
            ->get();
    }
}
