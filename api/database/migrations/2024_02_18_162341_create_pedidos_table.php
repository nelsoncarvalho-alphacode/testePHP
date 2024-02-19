<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer("quantidade_prod_pedido");
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('cliente_id');
            $table->timestamps();

            $table->foreign("produto_id")->references("id")->on("produtos")->onDelete('cascade');
            $table->foreign("cliente_id")->references("id")->on("clientes")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
