@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                @include('top_bar')
                {{-- confirmar deleção --}}
                <div class="col card p-5 text-center">
                    <h4 class="text-info mb-3">{{ $vaga->title }}</h4>
                    <p class="text-secondary">Deseja se inscrever nesta vaga?</p>
                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="btn btn-danger px-5 m-2">Não</a>
                        <a href="{{ route('inscreverVagaConfirm', ['id' => Crypt::encrypt($vaga['id'])]) }}"
                            class="btn btn-primary px-5 m-2">Sim
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
