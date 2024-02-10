<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'string|nullable',
            'barcode' => 'required|min:1|max:20',
            'price' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'O campo Nome do Produto deve ser string',
            'barcode.min' => 'O Código de Barras deve ser positivo',
            'barcode.max' => 'O Código de Barras deve ter no máximo 20 caracteres ',
            'barcode.required' => 'O Código de Barras é obrigatório',
            'price.required' => 'O campo Valor é obrigatório'
        ];
    }
}
