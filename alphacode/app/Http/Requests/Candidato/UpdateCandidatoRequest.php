<?php

namespace App\Http\Requests\Candidato;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCandidatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $candidatoId = $this->route('candidato')->id;

        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('candidatos', 'user_id')->ignore($candidatoId),
            ],
            'cpf' => [
                'nullable',
                'string',
                'max:14',
                Rule::unique('candidatos', 'cpf')->ignore($candidatoId),
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'formacao' => 'nullable|string',
            'experiencia_profissional' => 'nullable|string',
            'habilidades' => 'nullable|string',
            'curriculo' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O usuário é obrigatório para um perfil de candidato.',
            'user_id.exists' => 'O usuário selecionado não existe.',
            'user_id.unique' => 'Este usuário já possui um perfil de candidato associado.',
            'cpf.unique' => 'Este CPF já está cadastrado para outro candidato.',
            'cpf.max' => 'O CPF deve ter no máximo 14 caracteres.',
        ];
    }
}