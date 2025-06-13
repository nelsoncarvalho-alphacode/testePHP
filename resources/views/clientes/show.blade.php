@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detalhes do Cliente</h4>
                        <div>
                            <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-light">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card-body bg-dark text-white">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informações Pessoais</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-dark text-white">
                                    <strong>Nome:</strong> {{ $cliente->nome }}
                                </li>
                                <li class="list-group-item bg-dark text-white">
                                    <strong>CPF:</strong> {{ $cliente->cpf }}
                                </li>
                                <li class="list-group-item bg-dark text-white">
                                    <strong>E-mail:</strong> {{ $cliente->email }}
                                </li>
                                <li class="list-group-item bg-dark text-white">
                                    <strong>Cadastrado em:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}
                                </li>
                            </ul>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Estatísticas</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-dark text-white">
                                    <strong>Total de Pedidos:</strong> {{ $cliente->pedidos->count() }}
                                </li>
                                <li class="list-group-item bg-dark text-white">
                                    <strong>Valor Total Gasto:</strong> R$ {{ number_format($cliente->pedidos->sum('total'), 2, ',', '.') }}
                                </li>
                                <li class="list-group-item bg-dark text-white">
                                    <strong>Último Pedido:</strong> 
                                    @if($cliente->pedidos->count() > 0)
                                        {{ $cliente->pedidos->sortByDesc('data_pedido')->first()->data_pedido->format('d/m/Y') }}
                                    @else
                                        Nenhum pedido
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Histórico de Pedidos</h5>
                </div>
                
                <div class="card-body p-0 bg-dark">
                    @if($cliente->pedidos->count() > 0)
                        <div class="table-responsive bg-dark">
                            <table class="table table-dark table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nº Pedido</th>
                                        <th>Data</th>
                                        <th>Status</th>
                                        <th>Valor Total</th>
                                        <th>Itens</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedidos as $pedido)
                                    <tr>
                                        <td>#{{ str_pad($pedido->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $pedido->data_pedido->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($pedido->status == 'Pago') badge-success
                                                @elseif($pedido->status == 'Cancelado') badge-danger
                                                @else badge-warning
                                                @endif">
                                                {{ $pedido->status }}
                                            </span>
                                        </td>
                                        <td>R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                                        <td>{{ $pedido->produtos->count() }} itens</td>
                                        <td>
                                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-sm btn-primary">
                                                Detalhes
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info m-3 bg-dark text-white">
                            Este cliente ainda não realizou nenhum pedido.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection