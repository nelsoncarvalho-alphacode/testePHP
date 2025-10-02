<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
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
            'cliente_id'   => ['required', 'exists:clientes,id'],
            'data_pedido'  => ['required', 'date'],
            'status'       => ['required', 'in:em_aberto,pago,cancelado'],

            'itens'                     => ['required', 'array', 'min:1'],
            'itens.*.produto_id'        => ['required', 'exists:produtos,id'],
            'itens.*.quantidade'        => ['required', 'integer', 'min:1'],
            'itens.*.valor_unitario'    => ['required', 'numeric', 'min:0'],
        ];
    }
}
