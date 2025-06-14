<?php

namespace App\Http\Requests\Vaga;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteVagaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vaga_ids' => 'required|array',
            'vaga_ids.*' => 'integer|exists:vagas,id',
        ];
    }

     public function messages(): array
    {
        return [
            'vaga_ids.required' => 'Nenhuma vaga foi selecionada para exclusão em massa.',
            'vaga_ids.array' => 'O formato dos IDs das vagas é inválido.',
            'vaga_ids.*.integer' => 'Um dos IDs de vaga selecionados não é válido.',
            'vaga_ids.*.exists' => 'Uma das vagas selecionadas não existe.',
        ];
    }
}
