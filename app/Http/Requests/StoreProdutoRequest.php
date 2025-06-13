<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProdutoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cod_barras' => 'required|string|max:20|unique:produtos,cod_barras',
            'nome' => 'required|string|max:100',
            'valor_unitario' => 'required|numeric|min:0.01',
        ];
    }
}