<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Todos podem criar clientes (ou implemente lógica de permissão)
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:100',
            'cpf' => 'required|string|size:11|unique:clientes,cpf',
            'email' => 'required|email|max:100|unique:clientes,email',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome é obrigatório',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'email.email' => 'Informe um e-mail válido',
            // Adicione outras mensagens customizadas
        ];
    }
    
    public function attributes()
    {
        return [
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'E-mail',
        ];
    }
}