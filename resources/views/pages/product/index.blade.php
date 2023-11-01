@extends('layouts.app')

@section('tittle','Produtos')

@section('content')
    <form id="showProduct" method="GET" action="{{route('show_product')}}">
        <div class="card card-body">
            <div class="row">
                <div class="col-4">
                    <x-input name="name" id="nameFilter" label="Nome"
                             type="text" value="{{$name ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-input name="barCode" id="barCodeFilter" label="Codigo de Barras"
                             type="text" value="{{$cpf ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-input name="value" id="valueFilter" label="Valor"
                             type="number" value="{{$email ?? ''}}"/>
                </div>
                <div class="col-2 d-flex" style="align-self: end;">
                    <x-button-submit id="btn-submit" label="Buscar"/>
                </div>
            </div>
        </div>
    </form>
    <div class="card card-body">

        <table id="basic-datatable" class="table text-center dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Codigo de Barras</th>
                <th scope="col">Valor</th>
                <th scope="col">Estoque</th>
                <th scope="col">Detalhes</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->barCode}}</td>
                    <td>{{$product->value}}</td>
                    <td>{{$product->amount}}</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <button id="product{{$product->id}}" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-id="{{$product->id}}"
                                        data-name="{{$product->name}}"
                                        data-bar_code="{{$product->barCode}}"
                                        data-value="{{$product->value}}"
                                        data-amount="{{$product->amount}}"
                                        data-bs-target="#editProductModal">
                                    Editar
                                </button>
                            </div>
                            <div class="col">
                                <form id="deleteProduct" method="post"
                                      action="{{route('destroy_product',['product'=>$product->id])}}">
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            @include('pages.product.partials.edit_product')
            </tbody>
        </table>
    </div>
@endsection
<script>
    $(document).ready(function () {
        var campos = $("#nameFilter, #barCodeFilter, #valueFilter");

        campos.on('input', function () {

            var campoAtual = $(this);
            var outrosCampos = campos.not(campoAtual);

            if (campoAtual.val() !== "") {
                outrosCampos.prop('disabled', true);
            } else {
                outrosCampos.prop('disabled', false);
            }
        });
    });

</script>
