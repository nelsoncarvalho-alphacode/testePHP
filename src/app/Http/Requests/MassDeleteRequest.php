<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:' . $this->getTableName() . ',id'],
        ];
    }

    /**
     * Define exemplos e descrições dos parâmetros para a documentação do Scribe.
     */
    public function bodyParameters(): array
    {
        return [
            'ids' => [
                'description' => 'Lista de IDs que serão excluídos em lote.',
                'example' => [1, 2, 3], // 👈 Aqui você define o exemplo fixo
            ],
        ];
    }

    /**
     * Retorna dinamicamente o nome da tabela alvo
     * com base na rota que chamou a request.
     */
    private function getTableName(): string
    {
        $route = $this->route()->getName() ?? '';

        return match (true) {
            str_contains($route, 'vagas') => 'vagas',
            str_contains($route, 'candidatos') => 'candidatos',
            str_contains($route, 'inscricoes') => 'inscricoes',
            default => 'vagas', // fallback
        };
    }
}
