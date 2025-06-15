<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PaginatedOrderController extends Controller
{
    private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function getPaginated(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        $sortByColumn = $request->input('sortByColumn', 'id');
        $sortByType = $request->input('sortByType', 'ASC');
        $filterByValue = $request->input('filterByValue', '');
        $filterByDate = $request->input('filterByDate', '');
        $filterByStatus = $request->input('filterByStatus', '');

        try {
            $orders = $this->order->getPaginatedSortedAndFiltered($offset, $limit, $sortByColumn, $sortByType, $filterByValue, $filterByDate, $filterByStatus);

            return response()->json($orders, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar pedidos: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
