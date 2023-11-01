@extends('layouts.app')

@section('tittle','Cadastrar Pedido')

@section('content')
    <div class="card card-body">
        <form id="newPurchase" method="post" action="{{route('store_purchase')}}">
            <div class="row pb-3">
                <div class="col-3">
                    <x-select id="product" name="id_product" required class="orm-label"
                              :is-multi-select="false" :disabled="false" :dataset="$products"
                              :selected="[]" label="Produto" min="1">
                    </x-select>
                </div>
                <div class="col-3">
                    <x-select id="client" name="id_client" required class="form-control"
                              :is-multi-select="false" :disabled="false" :dataset="$clients"
                              :selected="[]" label="Cliente">
                    </x-select>
                </div>
                <div class="col-2">
                    <x-input id="percentage_descount"
                             name="percentage_descount" value="" required disabled="true"
                             type="number" label="Desconto %"></x-input>
                </div>
                <div class="col-2">
                    <x-input id="amountProduct"
                             name="amount_Buy" value="" required disabled="true"
                             type="number" label="Quantidade"></x-input>
                </div>
                <div class="col-2 d-flex" style="align-self: end;">
                    <x-button-submit id="btn-submit" label="Adicionar"/>
                </div>
            </div>
        </form>
    </div>
    <div class="card card-body">
        <div>
            <table id="basic-datatable" class="table text-center dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Codigo de Barras</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Estoque</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->barCode}}</td>
                        <td>{{$product->value}} R$</td>
                        <td>{{$product->amount}}</td>
                    </tr>
                @endforeach
                @include('pages.product.partials.edit_product')
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
                let amountAux = 0;
            $("#product").change(function () {
                $("#amountProduct").prop("disabled", false);
                $("#percentage_descount").prop("disabled", false);
                var selectedValue = $(this).val();
                if(!selectedValue){
                    $("#amountProduct").prop("disabled", true);
                    $("#percentage_descount").prop("disabled", true);
                }
                console.log(selectedValue)
                $.ajax({
                    url: '/product/amount/' + selectedValue, // Substitua pela sua rota real
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $("#amountProduct").attr("max", data);
                        amountAux = data;
                    },
                    error: function () {
                       console.log(data);
                    }
                });
            });
            $("#amountProduct").change(function () {
                var valor = $("#amountProduct").val();
                if (valor>amountAux){
                    alert("Valor maximo em estoque é: "+amountAux);
                }
            });
        });
    </script>
@endsection
