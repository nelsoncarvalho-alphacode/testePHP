<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdutoRequest extends FormRequest
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
        $produtoId = $this->route('produto');
        
        return [
            'nome'              => ['required', 'string', 'max:100'],
            'valor_unitario'    => ['required', 'numeric', 'min:0'],
            'codigo_barras'     => [
                'required',
                'string',
                'max:20',
                Rule::unique('produtos', 'codigo_barras')->ignore($produtoId),
            ],
        ];
    }
}
