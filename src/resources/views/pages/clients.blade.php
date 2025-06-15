@extends('layouts.app')

@section('content')
    <x-navbar :current="'clients'"/>
    <div class="mx-5">
        <form id="filter-form">
            <div class="input-group col-md">
                <x-input :type="'text'" :placeholder="'Buscar por nome, sobrenome, email ou CPF'" :id="'filter-by-value'"/>
            </div>
            <div class="d-flex justify-content-center mt-2 col-md">
                <button class="btn btn-outline-primary" style="width: 100px">Filtrar</button>
            </div>
        </form>
        <x-form :endpoint="'clients'" />
    </div>
@endsection
