<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiVagaController;
use App\Http\Controllers\Api\ApiCandidatoController;
use App\Http\Controllers\Api\ApiInscricaoController;








// Vagas
//Route::apiResource('vagas', ApiVagaController::class);
//Route::delete('vagas-mass', [ApiVagaController::class, 'destroyMass']);

// Candidatos
// Route::apiResource('candidatos', ApiCandidatoController::class);
// Route::delete('candidatos-mass', [ApiCandidatoController::class, 'destroyMass']);

// Inscrições
// Route::apiResource('inscricoes', ApiInscricaoController::class);
// Route::delete('inscricoes-mass', [ApiInscricaoController::class, 'destroyMass']);



Route::apiResource('vagas', ApiVagaController::class)->names('api.vagas');
Route::delete('vagas-mass', [ApiVagaController::class, 'destroyMass'])->name('api.vagas.mass');

// Candidatos API
Route::apiResource('candidatos', ApiCandidatoController::class)->names('api.candidatos');
Route::delete('candidatos-mass', [ApiCandidatoController::class, 'destroyMass'])->name('api.candidatos.mass');

// Inscrições API
Route::apiResource('inscricoes', ApiInscricaoController::class)->names('api.inscricoes');
Route::delete('inscricoes-mass', [ApiInscricaoController::class, 'destroyMass'])->name('api.inscricoes.mass');

