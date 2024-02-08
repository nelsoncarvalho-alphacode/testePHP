<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $clientRepository = new ClientRepository($this->client);

        if($request->has('search')){

            $clientRepository->filter($request->search);

            return response()->json($clientRepository->getResult(), 200);
        } else {
            $clients = $this->client->get();

            return response()->json($clients, 200);
        }
    }

    public function store(ClientRequest $request)
    {
        $data = $request->all();
        $this->client->create($data);
        return response()->json(['message' => 'Cliente cadastrado com sucesso!'], 201);
    }


    public function show($id)
    {
        $client = $this->client->find($id);
        if($client == null){
            return response()->json(['erro' => 'O usuário informado não existe'], 404);
        }
        return response()->json($client);
    }

    public function update(ClientRequest $request, $id)
    {
        $client = $this->client->find($id);
        $data = $request->all();
        if($client === null){
            return response()->json(['erro' => 'Cliente informado não existe'], 404);
        }
        $client->update($data);
        return response()->json(['message' => 'Cliente atualizado com sucesso'], 200);
    }

    public function destroy($id)
    {
        $client = $this->client->find($id);
        if($client == null){
            return response()->json(['erro' => 'Cliente informado não existe'], 404);
        }

        $client->delete();
        return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
    }
}
