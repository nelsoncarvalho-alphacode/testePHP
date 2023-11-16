<?php

namespace App\Http\Controllers;

use App\Models\Clientes\clientes;
use App\Services\Clientes\ClientesServices;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    protected $clientesModel;
    private $clientesServices;

    public function __construct(
        clientes    $clientesModel,
        ClientesServices    $clientesServices
    ) {
        $this->clientesModel = $clientesModel;
        $this->clientesServices = $clientesServices;
    }

    public function cadastro() {
        return view('Clientes/cadastro');
    }

    public function salvarCliente(Request $request) {
        $dados = $request->all();
        if ($request->isMethod('post')) {
            $this->clientesServices->salvarClientes($dados);
            return redirect()->route('produtos')->with('msg', "Cliente cadastrado com sucesso!");
        } else {
            echo 'tchau';
        }
    }
}
