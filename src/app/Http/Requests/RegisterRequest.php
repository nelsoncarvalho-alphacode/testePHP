<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
        ];
    }

    public function messages(): array
    {
    return [
        'name.required'     => 'O campo nome é obrigatório.',
        'name.string'       => 'O nome deve ser um texto válido.',
        'name.max'          => 'O nome não pode ter mais que :max caracteres.',

        'email.required'    => 'O campo e-mail é obrigatório.',
        'email.email'       => 'Informe um endereço de e-mail válido.',
        'email.unique'      => 'Já existe um usuário com este e-mail.',

        'password.required' => 'O campo senha é obrigatório.',
        'password.string'   => 'A senha deve ser um texto válido.',
        'password.min'      => 'A senha deve ter pelo menos :min caracteres.',
        'password.confirmed'=> 'A confirmação da senha não confere.',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
