<?php

namespace App\Services\Produtos;

interface ProdutosInterface
{
    public function salvarProduto(array $dados): void;
}
