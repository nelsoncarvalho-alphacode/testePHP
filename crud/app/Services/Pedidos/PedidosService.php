<?php

namespace App\Services\Pedidos;

use App\Models\Pedidos\pedidos;

class PedidosService
{
    public function salvarPedidos(array $dados): void
    {
        pedidos::create($dados);
    }
}
