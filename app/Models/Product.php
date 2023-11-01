<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ['name','barCode','value','amount'];



    public function purchaseRequest(): HasMany
    {
        return $this->hasMany(purchaseRequest::class, 'id_product');
    }
    public static function getAmountByProduct($id){
        $amount = Product::where('id',$id)->get();
        return $amount[0]->amount;
    }

    public static function getProductByName(mixed $name)
    {
        return Product::where('name', 'like', '%' . $name . '%')->get();
    }

    public static function getProductByCpf(mixed $barCode)
    {
        return Product::where('barCode', 'like', '%' . $barCode . '%')->get();
    }

    public static function getProductByEmail(mixed $value)
    {
        return Product::where('value', 'like', '%' . $value . '%')->get();
    }



    public function label()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->id;
    }

    use HasFactory;
    use SoftDeletes;
}
