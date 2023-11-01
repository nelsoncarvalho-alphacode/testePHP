@extends('layouts.app')

@section('tittle','Cadastrar produto')

@section('content')
    <form id="newProduct" method="post" action="{{route('store_product')}}">
        <div class="card card-body">
            <div class="row">
                <div class="col-4">
                    <x-input name="name" id="name" label="Nome" required="true"
                             type="text" value=""/>
                </div>
                <div class="col-3">
                    <x-input name="barCode" id="barCode" label="Codigo de Barras" required="true"
                             type="text" value=""/>
                </div>
                <div class="col-3">
                    <x-input name="value" id="value" label="Preço" required="true"
                             type="decimal" value=""/>
                </div>
                <div class="col-3">
                    <x-input name="amount" id="amount" label="Estoque" required="true"
                             type="decimal" value=""/>
                </div>

                <div class="col-2 d-flex" style="align-self: end;">
                    <x-button-submit id="btn-submit" label="Adicionar"/>
                </div>
            </div>
        </div>
    </form>
@endsection
