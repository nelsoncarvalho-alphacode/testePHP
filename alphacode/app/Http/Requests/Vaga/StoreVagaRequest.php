<?php

namespace App\Http\Requests\Vaga;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreVagaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'tipo_vaga' => ['required', Rule::in(['CLT', 'Pessoa Jurídica', 'Freelancer'])],
            'ativa' => 'boolean',
        ];
    }

     public function messages(): array
    {
        return [
            'titulo.required' => 'O título da vaga é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de :max caracteres.',
            'descricao.required' => 'A descrição da vaga é obrigatória.',
            'tipo_vaga.required' => 'O tipo de contratação é obrigatório.',
            'tipo_vaga.in' => 'O tipo de contratação selecionado é inválido.',
            'ativa.boolean' => 'O status de ativação deve ser verdadeiro ou falso.',
        ];
    }
}
