@extends('layouts.app')

@section('tittle','Pagina não Encontrada')

@section('content')
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <div class="text-center">
                                <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>4</h1>
                                <h4 class="text-uppercase text-danger mt-3">Pagina não Encontrada</h4>
                                <p class="text-muted mt-3">Poxa, ainda não temos essa tela, mais logo logo estaremos implantando novas funcionalidades.</p>

                                <a class="btn btn-info mt-3" href="{{route('create_purchase')}}"><i class="mdi mdi-reply"></i> Retorne para Inicio</a>
                            </div>
                        </div> <!-- end card-body-->
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

@endsection
