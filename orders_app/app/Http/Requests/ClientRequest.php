<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required',
            'cpf' => 'required|min:0|max:11|unique:clients,cpf,'.$this->client,
            'email' => 'nullable|unique:clients,email,'.$this->client
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo Nome do Cliente é obrigatório',
            'cpf.required' => 'O campo CPF é obrigatório',
            'cpf.unique' => 'O CPF informado já existe!',
            'cpf.min' => 'CPF dever ter valores positivos',
            'cpf.max' => 'O CPF deve ter no máximo 11 caracteres',
            'email.unique' => 'O Email informado já existe!'
        ];
    }
}
