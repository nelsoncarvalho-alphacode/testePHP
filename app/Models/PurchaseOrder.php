<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\PurchaseOrderItem;

class PurchaseOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'status',
        'total',
        'payment_method',
        'order_date',
        'order_number',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class, 'purchase_order_id', 'id');
    }

    public static function getOrdersQuery($sort, $direction, $deleted = false)
    {
        $columnsMap = [
            'cliente' => 'clients.name',
            'id' => 'purchase_orders.id',
            'status' => 'purchase_orders.status',
            'data' => 'purchase_orders.order_date',
        ];

        $column = $columnsMap[$sort] ?? 'purchase_orders.id';

        $query = PurchaseOrder::leftJoin('clients', 'purchase_orders.client_id', '=', 'clients.id')
            ->select('purchase_orders.*', 'clients.name');

        if ($deleted) {
            $query->onlyTrashed();
        }

        return $query->orderBy($column, $direction);
    }

    public static function getOrders($perPage, $sort, $direction)
    {
        return self::getOrdersQuery($sort, $direction)->paginate($perPage);
    }

    public static function getOrdersDeleted($perPage, $sort, $direction)
    {
        return self::getOrdersQuery($sort, $direction, true)->paginate($perPage);
    }

    public static function createPurchaseOrder($request, $orderNumber)
    {
        return PurchaseOrder::create([
            'client_id' => $request->input('client_id'),
            'status' => $request->input('status'),
            'total' => $request->input('total'),
            'payment_method' => $request->input('payment_method'),
            'order_date' => $request->input('order_date'),
            'order_number' => $orderNumber	
        ]);
    }
}
