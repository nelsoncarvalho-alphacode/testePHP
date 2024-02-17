<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatoVagaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidato_vaga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidato_id');
            $table->unsignedBigInteger('vaga_id');
            $table->timestamps();

            $table->foreign('candidato_id')->references('id')->on('candidatos')->onDelete('cascade');
            $table->foreign('vaga_id')->references('id')->on('vagas')->onDelete('cascade');

            $table->unique(['candidato_id', 'vaga_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidato_vaga');
    }
}
