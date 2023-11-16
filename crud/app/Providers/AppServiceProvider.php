<?php

namespace App\Providers;

use App\Services\Clientes\ClientesInterface;
use App\Services\Clientes\ClientesServices;
use App\Services\Produtos\ProdutosInterface;
use App\Services\Produtos\ProdutosServices;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
