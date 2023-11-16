<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_do_pedido')->unique()->nullable();
            $table->timestamp('data_do_pedido')->useCurrent();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->string('status')->default('Em aberto');
            $table->unsignedBigInteger('produto_id');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
