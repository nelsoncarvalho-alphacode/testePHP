@extends('layouts.app')

@section('tittle','Cadastrar cliente')

@section('content')
    <form id="newClient" method="post" action="{{route('store_client')}}">
        <div class="card card-body">
            <div class="row">
                <div class="col-4">
                    <x-input name="name" id="name" label="Nome" required="true"
                             type="text" value=""/>
                </div>
                <div class="col-3">
                    <x-input name="cpf" data-mask-format="000.000.000-00" id="cpf" label="CPF" required="true"
                             class="cpf-mask" type="text" value=""/>
                </div>
                <div class="col-3">
                    <x-input name="email" id="email" label="E-mail" required="true"
                             type="text" value=""/>
                </div>

                <div class="col-2 d-flex" style="align-self: end;">
                    <x-button-submit id="btn-submit" label="Adicionar"/>
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cpf = document.getElementById("cpf");

            cpf.addEventListener("input", function() {
                // Remove todos os caracteres que não são dígitos
                const cleanedValue = cpf.value.replace(/\D/g, "");

                // Limita o campo a 11 dígitos
                if (cleanedValue.length > 11) {
                    cpf.value = cpf.value.slice(0, 11);
                }

                // Aplica a máscara de CPF
                cpf.value = formatCPF(cleanedValue);
            });

            cpf.addEventListener("keydown", function(event) {
                const cleanedValue = cpf.value.replace(/\D/g, "");

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
