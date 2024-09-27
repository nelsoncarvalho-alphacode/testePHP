@extends('layout.base')

@section('extraCss')
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
@endsection

@section('content')
    @include('components.alerts')

    <h1>Produtos</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Adicionar Produto</a>
    <div class="table-responsive">
        <table class="stripe row-border order-column" style="width:100%" id="indexTable">
            <thead>
                <tr>
                    <th class="text-start">ID</th>
                    <th class="text-start">Código de Barras</th>
                    <th class="text-start">Nome do Produto</th>
                    <th class="text-start">Preço</th>
                    <th class="text-start">Ações</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="text-start">ID</th>
                    <th class="text-start">Código de Barras</th>
                    <th class="text-start">Nome do Produto</th>
                    <th class="text-start">Preço</th>
                    <th class="text-start">Ações</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="text-start">{{ $product->id }}</td>
                        <td class="text-start">{{ $product->barcode }}</td>
                        <td class="text-start">{{ $product->product_name }}</td>
                        <td class="text-start">R$ {{ $product->unit_price }}</td>
                        <td class="text-start">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm"><i
                                    class="bi bi-eye"></i></a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm"><i
                                    class="bi bi-pencil-fill"></i></a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('extraJs')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#indexTable tfoot th').each(function(i) {
                var title = $('#indexTable thead th')
                    .eq($(this).index())
                    .text();
                $(this).html(
                    '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
                );
            });

            // DataTable
            var table = $('#indexTable').DataTable({
                pageLength: 20,
                lengthMenu: [10, 20, 50, 100],
                language: {
                    lengthMenu: "Mostrar _MENU_ itens por página",
                    search: "Buscar na Tabela:",
                    paginate: {
                        first: "Primeiro",
                        last: "Último",
                        next: "Próximo",
                        previous: "Anterior"
                    },
                    info: "Mostrando _START_ a _END_ de _TOTAL_ itens",
                    infoEmpty: "Mostrando 0 a 0 de 0 itens",
                    infoFiltered: "(filtrado de _MAX_ itens no total)",
                    zeroRecords: "Nenhum item encontrado",
                    emptyTable: "Nenhum dado disponível na tabela"
                }
            });

            // Filter event handler
            $(table.table().container()).on('keyup', 'tfoot input', function() {
                table
                    .column($(this).data('index'))
                    .search(this.value)
                    .draw();
            });
        });
    </script>
@endsection
