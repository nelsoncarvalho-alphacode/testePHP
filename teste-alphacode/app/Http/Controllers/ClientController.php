<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientController extends Controller
{
    public function index(){
        $clients = Cliente::paginate(20);

        return view('clientes.list', ['clients' => $clients]);
    }

    public function create(){
        return view('clientes.create');
    }

    public function store(Request $request, Cliente $client){
        $data = $request->all();

        $client->create($data);

        return redirect()->route('clientes.list');
    }

    public function destroy(string|int $id){
        if(!$client = Cliente::find($id)){
            return back();
        }

        $client->delete();

        return redirect()->route('clientes.list');
    }

    public function edit(Cliente $client, string|int $id){
        if(!$client = $client->where('id', $id)->first()){
            return back();
        }

        return view('clientes.edit', compact('client'));
    }

    public function update(Request $request, Cliente $client, string|int $id){
        if(!$client = $client->find($id)){
            return back();
        }

        $client->update($request->all());

        return redirect()->route('clientes.list');
    }
}
