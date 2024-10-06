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
        Schema::create('vagas_requisitos', function (Blueprint $table) {
           
            $table->id();
            $table->unsignedBigInteger('vaga');
            $table->string('requisito');
            $table->timestamps();

            $table->foreign('vaga')->references('id')->on('vagas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('vagas_requisitos');
    }
};
