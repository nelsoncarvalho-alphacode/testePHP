<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'candidatos' no banco de dados.
     */
    public function up(): void
    {
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id(); // chave primária
            $table->string('nome'); // nome do candidato
            $table->string('email')->unique(); // email único
            $table->string('telefone', 20)->nullable(); // telefone opcional
            $table->text('curriculo')->nullable(); // pode ser link ou texto resumido
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverte a migration (drop da tabela 'candidatos').
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
