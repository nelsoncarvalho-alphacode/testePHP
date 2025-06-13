<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePedidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'produtos' => 'required|array|min:1',
            'produtos.*.id' => 'required|exists:produtos,id',
            'produtos.*.quantidade' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'produtos.required' => 'Adicione pelo menos um produto ao pedido',
            'produtos.*.id.exists' => 'Um dos produtos selecionados é inválido',
            'produtos.*.quantidade.min' => 'A quantidade mínima é 1',
        ];
    }
    
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->produtos) {
                $produtosIds = array_column($this->produtos, 'id');
                
                if (count($produtosIds) !== count(array_unique($produtosIds))) {
                    $validator->errors()->add('produtos', 'Não é permitido produtos duplicados no pedido');
                }
            }
        });
    }
}