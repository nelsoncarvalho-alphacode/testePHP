<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
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

        $clienteId = $this->route('cliente')?->id ?? null;

        return [
            'nome' => ['required', 'string', 'max:100'],
            'cpf'  => [
                'required',
                'string',
                'size:11',
                Rule::unique('clientes', 'cpf')->ignore($clienteId),
            ],
            'email' => ['nullable', 'string', 'email', 'max:100'],

        ];
    }
}
