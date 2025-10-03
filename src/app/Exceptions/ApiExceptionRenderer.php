<?php

namespace App\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class ApiExceptionRenderer
{
    protected static function jsonError(string $code, string $mensagem, int $status, array $extra = [])
    {
        return response()->json(array_merge([
            'code'     => $code,
            'mensagem' => $mensagem,
            'status'   => $status,
            'timestamp'=> now()->toDateTimeString()
        ], $extra), $status);
    }

    public static function register(Exceptions $exceptions): void
    {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                $previous = $e->getPrevious();

                if ($previous instanceof ModelNotFoundException) {
                    return self::jsonError('Registro não encontrado', 'O sistema não encontrou o registro solicitado', 404);
                }

                return self::jsonError('Endpoint inválido', 'O recurso solicitado não existe', 404);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return self::jsonError('Erro de validação', 'Os dados enviados são inválidos', 422, [
                    'erros' => $e->errors()
                ]);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return self::jsonError('Método não permitido', 'O método HTTP usado não é aceito para este endpoint', 405);
            }
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return self::jsonError('Erro interno', 'Ocorreu um erro inesperado, tente novamente mais tarde.', 500);
            }
        });
    }
}
