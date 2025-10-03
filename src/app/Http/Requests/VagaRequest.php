<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VagaRequest extends FormRequest
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
        return [
            'titulo'    => 'required|string|max:255|unique:vagas,titulo',
            'descricao' => 'required|string',
            'tipo'      => 'required|in:CLT,PJ,Freelancer',
            'status'    => 'required|in:ativa,pausada',
            'salario'   => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'titulo.required'    => 'O campo título é obrigatório.',
            'titulo.unique'      => 'Já existe uma vaga com este título.',
            'titulo.max'         => 'O título não pode ter mais que :max caracteres.',
            'descricao.required' => 'A descrição é obrigatória.',
            'tipo.required'      => 'O tipo de contratação é obrigatório.',
            'tipo.in'            => 'O tipo deve ser CLT, PJ ou Freelancer.',
            'status.required'    => 'O status é obrigatório.',
            'status.in'          => 'O status deve ser Ativa ou Pausada.',
            'salario.numeric'    => 'O salário deve ser um número válido.',
            'salario.min'        => 'O salário deve ser maior ou igual a zero.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'titulo'    => 'título',
            'descricao' => 'descrição',
            'tipo'      => 'tipo de contratação',
            'status'    => 'status',
            'salario'   => 'salário',
        ];
    }

    /**
     * Body parameters for API documentation.
     */
    public function bodyParameters(): array
    {
        return [
            'titulo' => [
                'description' => 'Título da vaga.',
                'example'     => 'Desenvolvedor PHP Pleno',
            ],
            'descricao' => [
                'description' => 'Descrição detalhada da vaga.',
                'example'     => 'Responsável por desenvolver e manter sistemas em PHP usando Laravel.',
            ],
            'tipo' => [
                'description' => 'Tipo de contratação.',
                'example'     => 'CLT',
            ],
            'status' => [
                'description' => 'Status da vaga (ativa ou pausada).',
                'example'     => 'ativa',
            ],
            'salario' => [
                'description' => 'Salário oferecido para a vaga (opcional).',
                'example'     => '7500.00',
            ],
        ];
    }
}
