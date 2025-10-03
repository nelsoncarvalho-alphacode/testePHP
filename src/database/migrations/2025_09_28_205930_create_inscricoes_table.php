<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'inscricoes' no banco de dados.
     * Essa tabela faz a ligação N:N entre candidatos e vagas.
     */
    public function up(): void
    {
        Schema::create('inscricoes', function (Blueprint $table) {
            $table->id(); // chave primária
            $table->foreignId('candidato_id')->constrained('candidatos')->onDelete('cascade'); // FK candidato
            $table->foreignId('vaga_id')->constrained('vagas')->onDelete('cascade'); // FK vaga
            $table->timestamp('data_inscricao')->useCurrent(); // data da inscrição
            $table->unique(['candidato_id', 'vaga_id']); // evita duplicidade
        });
    }

    /**
     * Reverte a migration (drop da tabela 'inscricoes').
     */
    public function down(): void
    {
        Schema::dropIfExists('inscricoes');
    }
};
