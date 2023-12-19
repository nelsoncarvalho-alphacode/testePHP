<?php

namespace App\Services\Clientes;

interface ClientesInterface
{
    public function salvarClientes(array $dados): void;
}
