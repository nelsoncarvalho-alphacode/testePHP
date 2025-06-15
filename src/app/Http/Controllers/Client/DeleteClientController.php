<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DeleteClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function delete(Request $request, string $id)
    {
        try {
            $this->client->remove($id);
            return response()->json(['message' => 'Cliente deletado com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar cliente: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
