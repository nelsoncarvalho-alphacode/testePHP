@extends('layouts.app')

@section('tittle','Produtos')

@section('content')
    <form id="showPurchase" method="GET" action="{{route('show_purchase')}}">
        <div class="card card-body">
            <div class="row">
                <div class="col-4">
                    <x-input name="id_client" id="id_client" label="Cliente"
                             type="text" value="{{$clientFilter ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-input name="id_product" id="id_product" label="Produto"
                             type="text" value="{{$productFilter ?? ''}}"/>
                </div>
                <div class="col-3">
                    <x-select id="status_id" name="id_status" :required="false" class="form-control"
                              :is-multi-select="false" :disabled="false" :dataset="$status"
                              :selected="$id_statusFilter ?? []" label="Status">
                    </x-select>
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
                <th scope="col">Cliente</th>
                <th scope="col">Produto</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Preço Bruto</th>
                <th scope="col">Preço/Desconto</th>
                <th scope="col">Status</th>
                <th scope="col">Data Compra</th>
                <th scope="col">Ação</th>
                <th scope="col">Detalhe</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->Clients->name ?? '- - -'}}</td>
                    <td>{{$order->Products->name ?? '- - -'}}</td>
                    <td>{{$order->amount_Buy}}</td>
                    <td>{{$order->value_unit*$order->amount_Buy.' R$'}}</td>
                    <td>{{$order->amount_Buy_descount.' R$ ('.$order->percentage_descount.' %)'}}</td>
                    <td>{{$order->Status->name}} ?? '- - -'</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        <div class="row">
                            @if($order->id_status == 1)

                                <div class="col">
                                    <form id="deleteClient" method="post"
                                          action="{{route('update_status_order',['id'=>$order->id,'status'=>3])}}">
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Cancelar</button>
                                    </form>
                                </div>
                                <div class="col">
                                    <form id="deleteClient" method="post"
                                          action="{{route('update_status_order',['id'=>$order->id,'status'=>2])}}">
                                        @method('PUT')
                                        <button type="submit" class="btn btn-primary">Pagar</button>
                                    </form>
                                </div>
                            @elseif($order->id_status == 3)
                                <span class="badge bg-danger rounded-pill">Cancelado</span>
                            @else
                                <span class="badge bg-success rounded-pill">Pago</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="col">
                            @if($order->id_status == 1)
                                <button id="order{{$order->id}}" type="button" class="btn btn-primary"
                                        data-bs-toggle="modal"
                                        data-id="{{$order->id}}"
                                        data-id_client="{{$order->id_client}}"
                                        data-id_product="{{$order->id_product}}"
                                        data-value_unit="{{$order->value_unit}}"
                                        data-amount_buy="{{$order->amount_Buy}}"
                                        data-percentage_descount="{{$order->percentage_descount}}"
                                        data-bs-target="#editOrderModal">
                                    Editar
                                </button>
                            @else
                                <span class="badge bg-primary rounded-pill">Fechado</span>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
            @include('pages.purchase.partials.edit_order')
    <script>
        $(document).ready(function () {
            var campos = $("#id_client, #id_product, #status_id");

            campos.on('input', function () {

                var campoAtual = $(this);
                var outrosCampos = campos.not(campoAtual);

                if (campoAtual.val() !== "") {
                    outrosCampos.prop('disabled', true);
                } else {
                    outrosCampos.prop('disabled', false);
                }
            });
            $("#updateLink").click(function (event) {
                event.preventDefault();
                var url = $(this).attr("href");
                $.ajax({
                    url: url,
                    type: 'PUT',
                    success: function (data) {
                    },
                    error: function (xhr, status, error) {
                    }
                });
            });
        });
    </script>
@endsection
