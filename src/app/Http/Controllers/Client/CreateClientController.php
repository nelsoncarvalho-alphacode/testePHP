<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CreateClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function create(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:40',
                'surname' => 'required|string|max:60',
                'email' => 'nullable|email|max:30|unique:clients,email',
                'cpf' => 'required|string|max:11|unique:clients,cpf|regex:/^\d{11}$/',
            ], [
                'name.required' => 'Nome obrigatório.',
                'name.max' => 'Nome muito longo.',
                'surname.required' => 'Sobrenome obrigatório.',
                'surname.max' => 'Sobrenome muito longo.',
                'email.email' => 'E-mail inválido.',
                'email.max' => 'E-mail muito longo.',
                'email.unique' => 'E-mail já cadastrado.',
                'cpf.required' => 'CPF obrigatório.',
                'cpf.regex' => 'CPF inválido. Deve conter apenas números.',
                'cpf.unique' => 'CPF já cadastrado.',
                'cpf.max' => 'CPF inválido. Deve conter 11 dígitos.',
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $data = $request->all();
            $this->client->create($data);

            return response()->json(['message' => 'Cliente criado com sucesso.'], Response::HTTP_CREATED);
        }catch(\Exception $e) {
            return response()->json(['error' => 'Erro ao criar cliente: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
