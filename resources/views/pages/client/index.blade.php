@extends('layouts.app')

@section('tittle','Clientes')

@section('content')

    <form id="newClient" method="GET" action="{{route('show_client')}}">
        <div class="card card-body">
            <div class="row">
                <div class="col-4">
                    <x-input name="name" id="nameFilter" label="Nome"
                             type="text" value="{{$name ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-input name="cpf" id="cpfFilter" label="CPF"
                             type="text" class="ls-mask-cpf" value="{{$cpf ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-input name="email" id="emailFilter" label="E-mail"
                             type="text" value="{{$email ?? ''}}"/>
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
                <th scope="col">E-mail</th>
                <th scope="col">CPF</th>
                <th scope="col">Editar</th>
                <th scope="col">Excluir</th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->cpf}}</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <button id="client{{$client->id}}" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-id="{{$client->id}}"
                                        data-id_form{{$client->id}}="{{$client->id}}"
                                        data-name="{{$client->name}}"
                                        data-email="{{$client->email}}"
                                        data-cpf="{{$client->cpf}}"
                                        data-bs-target="#editClientModal">
                                    Editar
                                </button>
                            </div>
                    </td>
                    <td>
                        <div class="col">
                            <form id="deleteClient" method="post"
                                  action="{{route('destroy_client',['client'=>$client->id])}}">
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary">Excluir</button>
                            </form>
                        </div>
    </div>
    </td>
    </tr>
    @endforeach
    @include('pages.client.partials.edit_client')
    </tbody>
    </table>
    </div>
    <script>
        $(document).ready(function () {


            var campos = $("#nameFilter, #cpfFilter, #emailFilter");

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
        document.addEventListener("DOMContentLoaded", function () {
            const cpfFilter = document.getElementById("cpf");

            cpfFilter.addEventListener("input", function () {
                // Remove todos os caracteres que não são dígitos
                const cleanedValue = cpfFilter.value.replace(/\D/g, "");

                // Limita o campo a 11 dígitos
                if (cleanedValue.length > 11) {
                    cpfFilter.value = cpfFilter.value.slice(0, 11);
                }

                // Aplica a máscara de CPF
                cpfFilter.value = formatCPF(cleanedValue);
            });

            cpfFilter.addEventListener("keydown", function (event) {
                const cleanedValue = cpfFilter.value.replace(/\D/g, "");

                // Impede a digitação após atingir 11 dígitos
                if (cleanedValue.length >= 11 && event.key.length === 1) {
                    event.preventDefault();
                }
            });

            function formatCPF(value) {
                const formattedValue = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                return formattedValue;
            }
        });
    </script>
@endsection
