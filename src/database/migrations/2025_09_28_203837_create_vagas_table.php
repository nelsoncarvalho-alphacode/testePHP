<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migration (criação da tabela 'vagas').
     */
    public function up(): void
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id(); // chave primária (auto increment)
            $table->string('titulo'); // título da vaga
            $table->text('descricao'); // descrição detalhada da vaga
            $table->enum('tipo', ['CLT', 'PJ', 'Freelancer'])->nullable(false); // tipo de contratação
            $table->enum('status', ['ativa', 'pausada'])->default('ativa'); // status da vaga
            $table->decimal('salario', 10, 2)->nullable(); // salário opcional
            $table->timestamps(); // campos created_at e updated_at
        });
    }

    /**
     * Reverte a migration (drop da tabela 'vagas').
     */
    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
