<?php

namespace App\Services\Clientes;

use App\Models\Clientes\clientes;

class ClientesServices
{
    public function salvarClientes(array $dados): void
    {
        clientes::create($dados);
    }
}
