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
        Schema::create('candidato_vaga', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('candidato');
            $table->unsignedBigInteger('vaga');
            $table->timestamps();

            $table->foreign('candidato')->references('id')->on('candidatos');
            $table->foreign('vaga')->references('id')->on('vagas');


        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::drop('candidato_vaga');
    }
};
