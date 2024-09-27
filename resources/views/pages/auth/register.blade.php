@extends('layout.auth')

@section('content')
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title text-center title-login"><a class="active"
                            href="{{ route('register') }}">Registrar</a> | <a class="select"
                            href="{{ route('login') }}">Login</a></h1>
                </div>

                <div class="card-body">

                    @include('components.alerts')

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Ex.: Camila Afonso Lemes" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Ex.: camilaafonsolemes@gmail.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary">Confirmar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
