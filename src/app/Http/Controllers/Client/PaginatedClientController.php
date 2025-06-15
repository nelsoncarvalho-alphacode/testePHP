<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class PaginatedClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function getPaginated(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 20);
        $sortByColumn = $request->input('sortByColumn', 'id');
        $sortByType = $request->input('sortByType', 'ASC');
        $filterByValue = $request->input('filterByValue', '');


        try {
            $clients = $this->client->getPaginatedSortedAndFiltered($offset, $limit, $sortByColumn, $sortByType, $filterByValue);

            return response()->json($clients, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar clientes: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
