<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
           $table->id();
            $table->foreignId('candidato_id')->constrained('candidatos')->onDelete('cascade');
            $table->foreignId('vaga_id')->constrained('vagas')->onDelete('cascade');
            $table->string('status')->default('pendente'); 
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->unique(['candidato_id', 'vaga_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
