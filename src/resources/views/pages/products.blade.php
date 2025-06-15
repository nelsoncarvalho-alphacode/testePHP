@extends('layouts.app')

@section('content')
    <x-navbar :current="'products'"/>
    <div class="mx-5">
        <form id="filter-form">
            <div class="input-group">
                <x-input :type="'text'" :placeholder="'Buscar por nome, preço, email ou código de barras'" :id="'filter-by-value'"/>
            </div>
            <div class="d-flex justify-content-center mt-2">
                <button class="btn btn-outline-primary" style="width: 100px">Filtrar</button>
            </div>
        </form>
        <x-form :endpoint="'products'" />
    </div>
@endsection
