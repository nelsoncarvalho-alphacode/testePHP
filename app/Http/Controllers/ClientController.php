<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientController extends Controller
{

    public function __construct(
        protected Client $client,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all() ?? [];
        return view('pages.client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.client.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = Client::create([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'cpf' => $request['cpf']]
            );
            DB::commit();
            return redirect()->route('create_client')->with('success', 'Cliente Cadastrado!');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('create_client')->with('error', 'Erro ao realizar o cadastro, email ou cpf já cadastrado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $name = $request->name;
        $cpf = $request->cpf;
        $email = $request->email;
        if (!empty($name)) {
            $clients = Client::getClientByName($name);
        } elseif (!empty($cpf)) {
            $clients = Client::getClientByCpf($cpf);
        } elseif (!empty($email)) {
            $clients = Client::getClientByEmail($email);
        } else {
            $clients = Client::all() ?? [];
        }
        return view('pages.client.index')->with([
            'clients' => $clients,
            'name' => $name,
            'cpf' => $cpf,
            'email' => $email,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $client = $this->client->find($request->id);
            $client->fill($request->input());
            $client->save();
            DB::commit();
            return redirect()->route('list_client')->with('success', 'Cliente Atualizado!');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_client')->with('error', 'Erro ao atualizar o cadastro.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $client = Client::findOrFail($id);
            $orders = PurchaseRequest::getOrdersByClientWithStatusOpem($id)->count();
            if ($orders){
                return redirect()->route('list_product')->with('error', 'Existe pedidos EM ABERTO para esse cliente.');
            }
            $client->delete();
            DB::commit();
            return redirect()->route('list_client')->with('success', 'Cluente Excluido.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->route('list_client')->with('error', 'Não foi possivel excluir o Cliente.');
        }
    }

}
