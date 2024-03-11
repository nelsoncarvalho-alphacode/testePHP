<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Client;
use App\Models\PurchaseOrder;

class ClientController extends Controller
{
    private function clientNotFound() {
        return redirect()->route('clients.index')->with('error', 'Cliente não encontrado.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $clients = Client::orderBy('name', 'asc')
            ->paginate($perPage);

        return view('clients.index', compact('clients', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:clients,email',
                'cpf' => 'required|string|unique:clients,cpf',
                'celphone' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'password' => 'required|string|min:6',
                'cep' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'addressNumber' => 'required|string|max:255',
                'complement' => 'nullable|string|max:255',
                'neighborhood' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
            ], [
                'name.required' => 'O nome é obrigatório.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso.',
                'cpf.required' => 'O CPF é obrigatório.',
                'cpf.unique' => 'Este CPF já está em uso.',
                'celphone.required' => 'O número de celular é obrigatório.',
                'date_of_birth.required' => 'A data de nascimento é obrigatória.',
                'date_of_birth.date' => 'Por favor, insira uma data válida.',
                'password.required' => 'A senha é obrigatória.',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
                'cep.required' => 'O CEP é obrigatório.',
                'address.required' => 'O endereço é obrigatório.',
                'addressNumber.required' => 'O número do endereço é obrigatório.',
                'neighborhood.required' => 'O bairro é obrigatório.',
                'city.required' => 'A cidade é obrigatória.',
                'state.required' => 'O estado é obrigatório.',
            ]);

            // Criação do cliente
            $client = Client::create($validatedData);
            $client->remember_token = Str::random(10);
            $client->save();

            return redirect()->route('clients.index')->with('success', 'Cliente adicionado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Redireciona de volta ao formulário com erros de validação
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {

            return redirect()->route('clients.index')->with('error', 'Erro ao adicionar o cliente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $client = Client::with('orders')->withTrashed()->findOrFail($id);

            // Verificar se a relação purchaseOrders está carregada e se há pedidos
            $hasOrders = optional($client->orders)->isNotEmpty();

            return view('clients.show', compact('client', 'hasOrders'));
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $client = Client::withTrashed()->findOrFail($id);

            return view('clients.edit', compact('client'));
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'cpf' => 'required|string',
                'celphone' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'cep' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'addressNumber' => 'required|string|max:255',
                'complement' => 'nullable|string|max:255',
                'neighborhood' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
            ], [
                'name.required' => 'O nome é obrigatório.',
                'name.max' => 'O nome deve ter no máximo :max caracteres.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'cpf.required' => 'O CPF é obrigatório.',
                'celphone.required' => 'O número de celular é obrigatório.',
                'date_of_birth.required' => 'A data de nascimento é obrigatória.',
                'date_of_birth.date' => 'Por favor, insira uma data válida.',
                'cep.required' => 'O CEP é obrigatório.',
                'address.required' => 'O endereço é obrigatório.',
                'addressNumber.required' => 'O número do endereço é obrigatório.',
                'neighborhood.required' => 'O bairro é obrigatório.',
                'city.required' => 'A cidade é obrigatória.',
                'state.required' => 'O estado é obrigatório.',
            ]);

            $client = Client::findOrFail($id);
    
            // Atualizar apenas os campos que foram modificados
            $client->fill($validatedData)->save();

            return redirect()->route('clients.index')->with('success', 'Informações do cliente atualizadas com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        } catch (\Exception $e) {

            return redirect()->route('clients.index')->with('error', 'Erro ao atualizar o cliente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client = Client::withTrashed()->findOrFail($id);
            $client->forceDelete();

            return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso.');
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        } catch (\Exception $e) {

            return redirect()->route('clients.index')->with('error', 'Erro ao deletar o cliente.');
        }
    }

    public function softDeleted(string $id)
    {
        try {
            $client = Client::find($id);
            $client->delete();
            
            return redirect()->route('clients.index')->with('success', 'Cliente deletado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        } catch (\Exception $e) {

            return redirect()->route('clients.index')->with('error', 'Erro ao deletar cliente.');
        }
    }

    public function showDeleted(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 20);

            $clients = Client::onlyTrashed()
                ->orderBy('name')
                ->paginate($perPage);

            if ($clients->isEmpty()) {
                return redirect()->route('clients.index')->with('error', 'Sem clientes deletado.');
            }

            return view('clients.showDeleted', compact('perPage', 'clients'));
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        }
    }

    public function restore(string $id)
    {
        try {
            $client = Client::withTrashed()->find($id);
            $client->restore();

            return redirect()->route('clients.index')->with('success', 'Cliente restaurado com sucesso');
        } catch (ModelNotFoundException $e) {

            return $this->clientNotFound();
        } catch (\Exception $e) {

            return redirect()->route('clients.index')->with('error', 'Erro ao restaurar cliente.');
        }
    }

    public function searchClients(Request $request)
    {
        $name = $request->input('name');
        $clients = Client::where('name', 'like', '%' . $name . '%')->take(10)->get();

        return response()->json($clients);
    }
}
