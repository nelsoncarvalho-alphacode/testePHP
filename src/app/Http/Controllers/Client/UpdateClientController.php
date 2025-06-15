<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class UpdateClientController extends Controller
{
    private $client;

    public function __construct() {
        $this->client = new Client();
    }

    public function update(Request $request, string $id)
    {

        try{
            $request->validate([
                'name' => 'string|max:40',
                'surname' => 'string|max:60',
                'email' => ['nullable','email','max:30',Rule::unique('clients', 'email')->ignore($id)],
                'cpf' => ['string','max:11',Rule::unique('clients', 'cpf')->ignore($id), 'regex:/^\d{11}$/'],
            ], [
                'name.string' => 'Nome não pode ser vazio.',
                'name.max' => 'Nome muito longo.',
                'surname.string' => 'Sobrenome não pode ser vazio.',
                'surname.max' => 'Sobrenome muito longo.',
                'email.email' => 'E-mail inválido.',
                'email.max' => 'E-mail muito longo.',
                'email.unique' => 'E-mail já cadastrado.',
                'cpf.string' => 'CPF não pode ser vazio.',
                'cpf.regex' => 'CPF inválido. Deve conter apenas números.',
                'cpf.unique' => 'CPF já cadastrado.',
                'cpf.max' => 'CPF inválido. Deve conter 11 dígitos.',
            ]);
        }catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], Response::HTTP_BAD_REQUEST);
        }

        try{
            $data = $request->all();
            $this->client->updateData($id, $data);

            return response()->json(['message' => 'Cliente atualizado com sucesso.'], Response::HTTP_OK);
        }catch(\Exception $e) {
            return response()->json(['error' => 'Erro ao criar cliente: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
