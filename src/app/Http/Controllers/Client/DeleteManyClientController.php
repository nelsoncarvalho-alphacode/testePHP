<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteManyClientController extends Controller
{
   private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function deleteMany(Request $request)
    {
        try{
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:clients,id',
            ]);
        }catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Dados inválidos: ' . $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }



        try {
            $this->client->removeMany($request->ids);
            return response()->json(['message' => 'Clientes deletados com sucesso.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar clientes: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
