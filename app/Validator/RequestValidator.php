<?php

namespace Validator;

// Classe responsável por validar requisições recebidas pela API
class RequestValidator
{
    // Armazena os dados da requisição (nesse caso, as rotas extraídas da URL)
    private $request;

    // Construtor recebe os dados da requisição e armazena no atributo privado
    public function __construct($request)
    {
        $this->request = $request;
    }
}
