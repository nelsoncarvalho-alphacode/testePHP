<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscricaoRequest extends FormRequest
{
    /**
     * Autoriza o request (aqui deixamos true para todos os usuários).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação da inscrição.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'candidato_id'   => 'required|exists:candidatos,id',
            'vaga_id'        => 'required|exists:vagas,id',
            'data_inscricao' => 'nullable|date',
        ];
    }


    public function messages(): array
    {
        return [
            'candidato_id.required' => 'O campo candidato é obrigatório.',
            'candidato_id.exists'   => 'O candidato informado não existe.',

            'vaga_id.required'      => 'O campo vaga é obrigatório.',
            'vaga_id.exists'        => 'A vaga informada não existe.',

            'data_inscricao.date'   => 'A data da inscrição deve ser uma data válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'candidato_id'   => 'candidato',
            'vaga_id'        => 'vaga',
            'data_inscricao' => 'data da inscrição',
        ];
    }

    public function bodyParameters(): array
{
    return [
        'candidato_id' => [
            'description' => 'ID do candidato que está se inscrevendo.',
            'example' => 5
        ],
        'vaga_id' => [
            'description' => 'ID da vaga para a inscrição.',
            'example' => 2
        ],
        'data_inscricao' => [
            'description' => 'Data da inscrição (opcional, padrão é data atual).',
            'example' => '2025-10-01 14:30:00'
        ],
    ];
}

}
