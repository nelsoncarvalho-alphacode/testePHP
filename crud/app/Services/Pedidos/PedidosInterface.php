<?php

namespace App\Services\Pedidos;

interface PedidosInterface
{
    public function salvarPedidos(array $dados): void;
}
