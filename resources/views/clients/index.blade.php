@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif
<h1>Lista de Clientes</h1>
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="mb-3">
        <a href="{{ route('clients.create') }}" class="btn btn-outline-success">Adicionar Cliente</a>
        <a href="{{ route('clients.show_deleted') }}" class="btn btn-outline-danger">Clientes Deletados</a>
    </div>
    <div class="col-md-2">
        <form action="{{ route('clients.index') }}" method="GET">
            <div class="input-group">
                <select name="per_page" class="form-control w-auto" onchange="this.form.submit()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </form>
    </div>
</div>
<div class="row">
    @if ($clients->isEmpty())
        <div class="col-md-12 mb-3">
            <div class="alert alert-warning" role="alert">
                Nenhum cliente encontrado.
            </div>
        </div>
    @else
        @foreach ($clients as $client)
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="card-title">{{ $client->name }}</h5>
                                <p class="card-text">Email: {{ $client->email }}</p>
                                <p class="card-text">CPF: {{ $client->cpf }}</p>
                                <p class="card-text">Celular: {{ $client->celphone }}</p>
                                <p class="card-text">Data de Nascimento: {{ $client->date_of_birth }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="card-text">CEP: {{ $client->cep }}</p>
                                <p class="card-text">Endereço: {{ $client->address . ($client->address_number ? ', ' . $client->address_number : '') . ($client->complement ? ' - Complemento: ' . $client->complement : '') }}</p>
                                <p class="card-text">Bairro: {{ $client->neighborhood }}</p>
                                <p class="card-text">Cidade: {{ $client->city }}</p>
                                <p class="card-text">Estado: {{ $client->state }}</p>
                            </div>
                            <div class="col-md-4">
                                <!-- Botões de ação -->
                                <a href="{{ route('clients.show', ['cliente' => $client->id]) }}" class="btn btn-info">Detalhes</a>
                                <a href="{{ route('clients.edit', ['cliente' => $client->id]) }}" class="btn btn-primary">Editar</a>
                                <form action="{{ route('clients.soft_deleted', ['cliente' => $client->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Deletar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if ($clients->links() && $clients->lastPage() > 1)
        <nav class="mt-4">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($clients->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $clients->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Current Page --}}
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $clients->currentPage() }}</span>
                </li>
                {{-- Total Pages --}}
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">of {{ $clients->lastPage() }}</span>
                </li>

                {{-- Next Page Link --}}
                @if ($clients->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $clients->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
@endsection

@section('script')
<script>
    window.setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos

    window.setTimeout(function() {
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.display = 'none';
        }
    }, 3000); // 3 segundos
</script>
@endsection
