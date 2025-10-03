<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Quando for update, pega o id do candidato atual
        $id = $this->candidato?->id;

        return [
            'nome'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:candidatos,email,' . ($id ?? 'NULL'),
            'telefone' => 'nullable|string|max:20',
            'curriculo'=> 'nullable|string|max:255',
            'vagas'    => 'nullable|array',
            'vagas.*'  => 'exists:vagas,id',
        ];
    }


    /**
     * Mensagens personalizadas de validação.
     */
    public function messages(): array
    {
        return [
            'nome.required'     => 'O campo nome é obrigatório.',
            'nome.max'          => 'O nome não pode ter mais que :max caracteres.',

            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'email.max'         => 'O e-mail não pode ter mais que :max caracteres.',
            'email.unique'      => 'Já existe um candidato com este e-mail.',

            'telefone.max'      => 'O telefone não pode ter mais que :max caracteres.',

            'curriculo.max'     => 'O currículo não pode ter mais que :max caracteres.',

            'vagas.array'       => 'O campo vagas deve ser uma lista de IDs.',
            'vagas.*.exists'    => 'Alguma vaga informada não existe no sistema.',
        ];
    }

    /**
     * Tradução dos atributos para exibição nas mensagens.
     */
    public function attributes(): array
    {
        return [
            'nome'      => 'nome',
            'email'     => 'e-mail',
            'telefone'  => 'telefone',
            'curriculo' => 'currículo',
            'vagas'     => 'vagas',
        ];
    }

    /**
     * Documentação para Scribe (se você estiver usando).
     */

    public function bodyParameters(): array
{
    return [
        'nome' => [
            'description' => 'Nome completo do candidato.',
            'example' => 'Maria da Silva'
        ],
        'email' => [
            'description' => 'E-mail único do candidato.',
            'example' => 'maria.silva@email.com'
        ],
        'telefone' => [
            'description' => 'Telefone de contato (opcional).',
            'example' => '(11) 98888-7777'
        ],
        'curriculo' => [
            'description' => 'Link ou caminho do currículo (opcional).',
            'example' => 'https://meusite.com/cv/maria.pdf'
        ],
        'vagas' => [
            'description' => 'Lista de IDs das vagas às quais o candidato está se inscrevendo (opcional).',
            'example' => [1, 3]
        ],
    ];
}

}
