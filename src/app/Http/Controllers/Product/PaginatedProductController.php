<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PaginatedProductController extends Controller
{
    private $product;

    public function __construct() {
        $this->product = new Product();
    }

    public function getPaginated(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        $sortByColumn = $request->input('sortByColumn', 'id');
        $sortByType = $request->input('sortByType', 'ASC');
        $filterByValue = $request->input('filterByValue', '');


        try {
            $products = $this->product->getPaginatedSortedAndFiltered($offset, $limit, $sortByColumn, $sortByType, $filterByValue);

            return response()->json($products, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar produtos: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
