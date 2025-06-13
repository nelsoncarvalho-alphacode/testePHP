<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique(); 
            $table->string('cpf')->nullable()->unique();
            $table->string('telefone')->nullable();
            $table->text('endereco')->nullable(); 
            $table->text('formacao')->nullable();
            $table->text('experiencia_profissional')->nullable();
            $table->text('habilidades')->nullable();
            $table->text('curriculo')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
