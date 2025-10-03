<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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

    public function attributes(): array
    {
        return [
            'token' => 'token',
            'email' => 'e-mail',
            'password' => 'senha',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required'    => 'O token é obrigatório.',
            'token.string'      => 'O token deve ser um texto válido.',

            'email.required'    => 'O campo e-mail é obrigatório.',
            'email.email'       => 'Informe um endereço de e-mail válido.',
            'email.exists'      => 'Este e-mail não está cadastrado no sistema.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.string'   => 'A senha deve ser um texto válido.',
            'password.min'      => 'A senha deve ter pelo menos :min caracteres.',
            'password.confirmed'=> 'A confirmação da senha não confere.',
        ];
    }



    public function rules(): array
    {
        return [
            'token' => 'required|string',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
