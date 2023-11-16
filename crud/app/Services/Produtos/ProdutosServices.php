<?php

namespace App\Services\Produtos;

use App\Models\Produtos\produtos;

class ProdutosServices
{
    public function salvarProduto(array $dados): void
    {
        produtos::create($dados);
    }
}
