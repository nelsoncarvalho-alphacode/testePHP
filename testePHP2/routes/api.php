<?php

use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\VagaController;
use Illuminate\Support\Facades\Route;

Route::controller(VagaController::class)->group(function () {
    Route::get('/', 'index')->name('vagas.index');
    Route::get('/cadastrar-vagas', 'create')->name('vagas.create');
    Route::post('/store-vaga', 'store')->name('vagas.store');
    Route::get('/editar-vaga/{id}', 'edit')->name('vagas.edit');
    Route::put('/edit-vaga/{id}', 'update')->name('vagas.update');
    Route::delete('/deletar-vaga/{id}', 'destroy')->name('vagas.destroy');
    Route::delete('/vagas/deletar-em-massa', 'deletarEmMassa')->name('vagas.deletar_em_massa');
    Route::put('/vagas/pausar/{id}', 'pausar')->name('vagas.pausar');
});

Route::controller(CandidatoController::class)->group(function () {
    Route::get('/candidatos', 'index')->name('candidatos.index');
    Route::get('/cadastrar-candidatos', 'create')->name('candidatos.create');
    Route::post('/store-candidatos', 'store')->name('candidatos.store');
    Route::get('/editar-canditado/{id}', 'edit')->name('candidatos.edit');
    Route::put('/edit-canditado/{id}', 'update')->name('candidatos.update');
    Route::delete('/deletar-canditado/{id}', 'destroy')->name('candidatos.destroy');
    Route::delete('/candidatos/deletar-em-massa', 'deletarEmMassa')->name('candidatos.deletar_em_massa');
    Route::post('/candidatos/inscrever', 'inscrever')->name('candidatos.inscrever');
});
