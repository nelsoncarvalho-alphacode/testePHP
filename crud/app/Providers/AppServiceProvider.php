<?php

namespace App\Providers;

use App\Services\Clientes\ClientesInterface;
use App\Services\Clientes\ClientesServices;
use App\Services\Produtos\ProdutosInterface;
use App\Services\Produtos\ProdutosServices;
use App\Services\Pedidos\PedidosInterface;
use App\Services\Pedidos\PedidosService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProdutosInterface::class, ProdutosServices::class);
        $this->app->bind(ClientesInterface::class, ClientesServices::class);
        $this->app->bind(PedidosInterface::class, PedidosService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
