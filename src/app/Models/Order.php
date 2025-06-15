<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Product;

class Order extends Model
{
    protected $fillable = [
        "client_id",
        "product_id",
        "quantity",
        "status",
        "order_date",
        "discount"
    ];

    public function create(array $data)
    {
        $this->fill($data)->save();
        return;
    }

    public function updateData(int $id, array $data)
    {
        return [$id, $data];
        $this->where('id', $id)->update($data);
        return;
    }

    public function remove(int $id)
    {
        $this->where("id", $id)->delete();
        return;
    }

    public function getPaginatedSortedAndFiltered(int $offset=0, int $limit=20, string $sortByColumn='id', string $sortByType='ASC', string $filterByValue='', string $filterByDate='', string $filterByStatus='')
    {
        if(strlen($filterByValue) > 0 || strlen($filterByDate) > 0 || strlen($filterByStatus) > 0){
            $client = new Client();
            $product = new Product();

            $clientResultFromQuery = !empty($filterByValue) ? $client->getByName((string) $filterByValue) : null;
            $productResultFromQuery = !empty($filterByValue) ? $product->getByName((string) $filterByValue) : null;

            $clientId = !empty($clientResultFromQuery) ? $clientResultFromQuery->id : null;
            $productId = !empty($productResultFromQuery) ? $productResultFromQuery->id : null;

            $raw = "";
            if(strlen($filterByStatus) > 0 && strlen($filterByDate) > 0) $raw = "`status` = '$filterByStatus' and `order_date` = '$filterByDate'";
            else if(strlen($filterByStatus) > 0) $raw = "`status` = '$filterByStatus'";
            else if(strlen($filterByDate) > 0) $raw = "`order_date` = '$filterByDate'";


            $collection = strlen($raw) > 0 ? $this->whereRaw($raw)->where('quantity', !empty($filterByValue) ? '=' : "!=", $filterByValue) : $this->where('quantity', !empty($filterByValue) ? '=' : "!=", $filterByValue);

            if($clientId)
                $collection = $collection->orWhere('client_id', '=', $clientId);
            if($productId)
                $collection = $collection->orWhere('product_id', '=', $productId);

            $collection = $collection->join('products', 'products.id', '=', 'orders.product_id')->join('clients', 'clients.id', '=', 'orders.client_id')->select('orders.*', 'products.name as product_name', 'products.price as product_price', 'clients.name as client_name', 'clients.surname as client_surname');

            if($sortByColumn === 'total'){
                $collection = $collection->orderByRaw('products.price * orders.quantity * (1 - COALESCE(orders.discount, 0)) '.strtoupper($sortByType));
            }else if(str_starts_with($sortByColumn, "client_") || str_starts_with($sortByColumn, "product_")){
                $arrAux = explode("_", $sortByColumn);

                $tableName = $arrAux[0]."s";
                $columnName = $arrAux[1];

                if(strtoupper($sortByType) === 'ASC')
                    $collection = $collection->orderBy("$tableName.$columnName");
                else
                    $collection = $collection->orderByDesc("$tableName.$columnName");
            }else{
                if(strtoupper($sortByType) === 'ASC')
                    $collection = $collection->orderBy("orders.".$sortByColumn);
                else
                    $collection = $collection->orderByDesc("orders.".$sortByColumn);
            }

            $count = $collection->count();
            $data = [
                "total" => $count,
                "items" => $collection
                    ->offset($offset)
                    ->limit($limit)
                    ->get()
            ];

            return $data;
        }else{
            $collection = $this
                ->join('products', 'products.id', '=', 'orders.product_id')
                ->join('clients', 'clients.id', '=', 'orders.client_id')
                ->select('orders.*', 'products.name as product_name', 'products.price as product_price', 'clients.name as client_name', 'clients.surname as client_surname');

            if($sortByColumn === 'total'){
                $collection = $collection->orderByRaw('products.price * orders.quantity * (1 - COALESCE(orders.discount, 0)) '.strtoupper($sortByType));
            }else if(str_starts_with($sortByColumn, "client_") || str_starts_with($sortByColumn, "product_")){
                $arrAux = explode("_", $sortByColumn);

                $tableName = $arrAux[0]."s";
                $columnName = $arrAux[1];

                if(strtoupper($sortByType) === 'ASC')
                    $collection = $collection->orderBy("$tableName.$columnName");
                else
                    $collection = $collection->orderByDesc("$tableName.$columnName");
            }else
                $collection = strtoupper($sortByType) === 'ASC' ? $collection->orderBy("orders.".$sortByColumn) : $collection->orderByDesc("orders.".$sortByColumn);

            $count = $collection->count();
            $data = [
                "total" => $count,
                "items" => $collection
                    ->offset($offset)
                    ->limit($limit)
                    ->get()
            ];

            return $data;
        }
    }

    public function removeMany(array $ids)
    {
        if(count($ids) > 0){
            $this->whereIn("id", $ids)->delete();
            return;
        }
        return;
    }
}

