<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class PurchaseRequest extends Model
{
    protected $fillable = ['id_client','id_product','id_status','value_unit','amount_Buy','percentage_descount','amount_Buy_descount'];
    protected $table = 'purchase_requests';



    public function clients(): BelongsTo
    {
        return $this->belongsTo(client::class, 'id_client');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
    public static function getOrdersByClientId($client_id){
        return PurchaseRequest::where('id_client',$client_id)->get();
    }
    public static function getOrdersByStatus($id_status)
    {
        return PurchaseRequest::where('id_status',$id_status)->get();
    }
    public static function getOrdersByProductWithStatusOpem($id_product)
    {
        return PurchaseRequest::where('id_product',$id_product)->where('id_status',1)->get();
    }

    public static function getOrdersByProductId($id)
    {
        return PurchaseRequest::where('id_product',$id)->get();
    }
    public static function getOrdersByClientWithStatusOpem($id_client)
    {
        return PurchaseRequest::where('id_client',$id_client)->where('id_status',1)->get();
    }

    use HasFactory;
    use SoftDeletes;
}
