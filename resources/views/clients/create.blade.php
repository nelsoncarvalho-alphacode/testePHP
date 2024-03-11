@extends('layouts.app')

@section('css')
<style>
    input[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
</style>
@endsection

@section('content')
<h1>Adicionar Cliente</h1>
<form method="POST" action="{{ route('clients.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Nome<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email<span class="text-danger">*</span>:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="cpf" name="cpf" value="{{ old('cpf') }}" required>
            </div>

            <div class="mb-3">
                <label for="celphone" class="form-label">Celular<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="celphone" name="celphone" value="{{ old('celphone') }}" required maxlength="16">
            </div>

            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Data de Nascimento<span class="text-danger">*</span>:</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha<span class="text-danger">*</span>:</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="alert alert-info mt-2">
                    <ul class="mb-0">
                        <li>Deve conter pelo menos um dígito numérico.</li>
                        <li>Deve conter pelo menos uma letra minúscula.</li>
                        <li>Deve conter pelo menos uma letra maiúscula.</li>
                        <li>Deve ter no mínimo 8 caracteres de comprimento.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="cep" class="form-label">CEP<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="cep" name="cep" value="{{ old('cep') }}" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Endereço<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required readonly>
            </div>

            <div class="mb-3">
                <label for="addressNumber" class="form-label">Número<span class="text-danger">*</span>:</label>
                <input type="number" class="form-control" id="addressNumber" value="{{ old('addressNumber') }}" name="addressNumber" required>
            </div>

            <div class="mb-3">
                <label for="complement" class="form-label">Complemento:</label>
                <input type="text" class="form-control" id="complement" value="{{ old('complement') }}" name="complement">
            </div>

            <div class="mb-3">
                <label for="neighborhood" class="form-label">Bairro<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="neighborhood" name="neighborhood" value="{{ old('neighborhood') }}" required readonly>
            </div>

            <div class="mb-3">
                <label for="city" class="form-label">Cidade<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}" required readonly>
            </div>

            <div class="mb-3">
                <label for="state" class="form-label">Estado<span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" id="state" name="state" value="{{ old('state') }}" required readonly>
            </div>
        </div>
    </div>

    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-success">Adicionar Cliente</button>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</form>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Validação do campo 'cep' , preenchimento dos campos de endereço e mascaramento do campo 'cep'
        $('#cep').on('input', function() {
            let cep = $(this).val().replace(/\D/g, '');

            // Verifica se o CEP possui 8 dígitos
            if (cep.length != 8) {
                return;
            }

            // Requisição AJAX para a API ViaCEP
            $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                // Verifica se não há erro na resposta
                if (!('erro' in data)) {
                    // Preenche os campos de endereço com os dados obtidos
                    $('#address').val(data.logradouro);
                    $('#neighborhood').val(data.bairro);
                    $('#city').val(data.localidade);
                    $('#state').val(data.uf);
                    $('#addressNumber').focus();
                    $(this).removeClass('is-invalid');
                } else {                    
                    $(this).addClass('is-invalid');
                }
            });

            // Aplica máscara ao campo 'cep'
            $(this).mask('00000-000');
        });

        // Validação do campo 'cpf' e aplicação de máscara
        $('#cpf').on('input', function() {
            let cpf = $(this).val();

            if (validaCPF(cpf)) {
                $(this).removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid');
            }

            // Aplica máscara ao campo 'cpf'
            $(this).mask('000.000.000-00');
        });

        // Aplica máscara ao campo 'telefone' ou 'celular' baseado no valor digitado
        $('#celphone').on('input', function() {
            let number = $(this).val().replace(/\D/g, '');

            if (number.length === 11) {
                $(this).val(number.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4'));
            } else if (number.length === 10) {
                $(this).val(number.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3'));
            }
        });

        // Validação do campo email
        $('#email').on('input', function() {
            let email = $(this).val();

            if (validaEmail(email)) {
                $(this).removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid');
            }
        });

        // Validação do campo data de nascimento
        $('#date_of_birth').on('input', function() {
            var data = $(this).val();

            if (validaData(data)) {
                $(this).removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid');
            }
        });

        // Validação do campo senha
        $('#password').on('input', function() {
            var senha = $(this).val();

            if (validaSenha(senha)) {
                $(this).removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid');
            }
        });
    });

    function validaCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') return false;
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return false;
        add = 0;
        for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return false;
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
            return false;
        return true;
    }

    function validaEmail(email) {
        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function validaData(data) {
        return !isNaN(Date.parse(data));
    }

    function validaSenha(senha) {
        var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
        return re.test(senha);
    }
</script>
@endsection