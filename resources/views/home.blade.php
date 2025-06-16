@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">

                @include('top_bar')
                @if (session('user.type') != 'empresa')
                    <div class="my-3">
                        <a href="{{ route('subscriptions') }}" class="btn btn-warning rounded-pill px-4 py-2">Minhas vagas</a>
                    </div>
                @endif
                {{-- nenhuma vaga dispponível --}}
                @if (count($vagas) == 0)
                    <div class="row mt-5">
                        <div class="col text-center">
                            <p class="display-6 mb-5 text-secondary opacity-50">Não há vagas disponíveis.</p>
                            @if ($user == 'empresa')
                                <a href="{{ route('new') }}" class="btn btn-secondary btn-lg p-3 px-5">
                                    Criar primeira vaga
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    @if (session('user.type') == 'empresa')
                        <div class="text-center">
                            <p class="display-6 my-4 text-secondary opacity-50">Vagas abertas</p>
                        </div>
                    @else
                        <div class="text-center">
                            <p class="display-6 my-4 text-secondary opacity-50">Vagas disponíveis</p>
                        </div>
                    @endif
                    {{-- Vagas disponíveis --}}
                    @if (session('user.type') == 'empresa')
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('new') }}" class="btn btn-secondary px-3">
                                Criar vaga
                            </a>
                        </div>
                    @endif
                    @foreach ($vagas as $vaga)
                        @include('vaga')
                    @endforeach
                @endif
                <div class="d-flex justify-content-between">
                    <div class="fs-6 text-secondary">
                        <form method="GET" class="mb-3">
                            <label for="per_page">Itens por página:</label>
                            <select name="items_per_page" class="form-select-sm" id="per_page"
                                onchange="this.form.submit()">
                                <option value="5" {{ request('items_per_page') == '5' ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('items_per_page') == '10' ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('items_per_page') == '20' ? 'selected' : '' }}>20</option>
                            </select>
                        </form>
                    </div>
                    <div>
                        {{ $vagas->appends(['items_per_page' => request('items_per_page')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
