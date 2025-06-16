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
            $table->unsignedBigInteger('vaga_id');
            $table->unsignedBigInteger('candidato_id');

            $table->foreign('vaga_id')->references('id')->on('vagas')->onDelete('cascade');
            $table->foreign('candidato_id')->references('id')->on('candidatos')->onDelete('cascade');

            $table->primary(['vaga_id', 'candidato_id']); // garante a unicidade da combinação
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidato_vaga');
    }
};
