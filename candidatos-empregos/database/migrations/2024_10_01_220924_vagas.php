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
        Schema::create('vagas', function (Blueprint $table) {
           
            $table->id();
            $table->string('titulo');
            $table->string('descricao');
            $table->boolean('ativa');
            $table->unsignedBigInteger('empresa');
            $table->unsignedBigInteger('tipo_contrato');
            $table->timestamps();

            $table->foreign('empresa')->references('id')->on('empresas');
            $table->foreign('tipo_contrato')->references('id')->on('tipo_contrato');


        });
    }

    /**
     * Reverse the migrations.
     */


    public function down(): void
    {
        Schema::drop('vagas');
    }
};
