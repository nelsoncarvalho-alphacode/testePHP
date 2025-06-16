@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                @include('top_bar')
                {{-- nenhuma inscrição --}}
                @if (count($vagas) == 0)
                    <div class="col text-center mt-5">
                        <p class="display-6 mb-5 text-secondary opacity-50">Nenhuma inscrição encontrada</p>
                    </div>
                @else
                    <div class="col text-center">
                        <p class="display-6 my-4 text-secondary opacity-50">Minhas vagas</p>
                    </div>
                    @foreach ($vagas as $vaga)
                        @include('subscription_vaga')
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
                <div class="text-center mt-5 mb-3">
                    <a href="{{ route('home') }} " class="btn btn-secondary btn-lg p-3 px-5">
                        Vagas disponíveis
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
