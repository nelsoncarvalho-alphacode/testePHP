<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O campo Cliente é obrigatório',
            'client_id.exists' => 'O Cliente informado não existe!',
            'product_id.required' => 'O campo Produto é obrigatório',
            'product_id.exists' => 'O Produto informado não existe!',
            'quantity.required' => 'O campo Quantidade é obrigatório',
            'quantity.min' => 'A Quantidade mínima é 0',
            'status.required' => 'O campo Status é obrigatório'
        ];
    }
}
