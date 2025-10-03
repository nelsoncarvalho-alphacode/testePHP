<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Campos que nunca devem aparecer em erros de validação
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registrar callbacks de exceções.
     */
    public function register(): void
    {
        // Você pode registrar callbacks aqui se precisar no futuro.
    }
}
