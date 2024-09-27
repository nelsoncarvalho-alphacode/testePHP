<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('pages.clients.index', compact('clients'))->with('title', 'Lista de Clientes');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.clients.create')->with('title', 'Novo Cliente');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|max:100',
            'cpf' => 'required|size:11',
            'email' => 'nullable|email|max:100',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return view('pages.clients.show', compact('client'))->with('title', 'Mostrar Cliente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('pages.clients.edit', compact('client'))->with('title', 'Editar Cliente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'client_name' => 'required|max:100',
            'cpf' => 'required|size:11',
            'email' => 'nullable|email|max:100',
        ]);

        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente excluso com sucesso.');
    }
}
