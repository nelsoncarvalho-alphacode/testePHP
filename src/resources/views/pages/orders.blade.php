@extends('layouts.app')

@section('content')
    <x-navbar :current="'orders'"/>
    <div class="mx-5">
        <form id="filter-form">
            <div class="row gap-1">
                <div class="input-group col-md ">
                    <x-input :type="'text'" :placeholder="'Buscar por número do pedido, cliente, produto, valor unitário, quantidade ou desconto'" :id="'filter-by-value'"/>
                </div>
                <div class="input-group col-md">
                    <x-select :id="'filter-by-status'" :placeholder="'Filtrar por status'" :options="[
                        ['', 'Todos'],
                        ['pending', 'Em aberto'],
                        ['canceled', 'Cancelado'],
                        ['payed', 'Pago']
                    ]" />
                </div>
                <div class="input-group col-md">
                    <x-input :type="'date'" :placeholder="'Buscar por data'" :id="'filter-by-date'"/>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button class="btn btn-outline-primary" style="width: 100px">Filtrar</button>
            </div>
        </form>
        <x-form :endpoint="'orders'" />
    </div>
@endsection
