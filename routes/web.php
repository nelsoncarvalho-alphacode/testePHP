<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckIsNotLogged;
use App\Http\Middleware\CheckIsLogged;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação - usuário não está logado
Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);

    // criar candidato
    Route::get('/newCandidato', [MainController::class, 'newCandidato'])->name('newCandidato');
    Route::post('/newCandidatoSubmit', [MainController::class, 'newCandidatoSubmit'])->name('newCandidatoSubmit');
});

// Rotas do sistema - usuário logado
Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newVaga', [MainController::class, 'newVaga'])->name('new');
    Route::post('/newVagaSubmit', [MainController::class, 'newVagaSubmit'])->name('newVagaSubmit');

    // editar vaga
    Route::get('/editVaga/{id}', [MainController::class, 'editVaga'])->name('edit');
    Route::post('/editVagaSubmit', [MainController::class, 'editVagaSubmit'])->name('editVagaSubmit');

    // exluir vaga
    Route::get('/delete/{id}', [MainController::class, 'deleteVaga'])->name('delete');
    Route::get('/deleteVagaConfirm/{id}', [MainController::class, 'deleteVagaConfirm'])->name('deleteConfirm');

    // editar candidato
    Route::get('/editCandidato/{id}', [MainController::class, 'editCandidato'])->name('editCandidato');
    Route::post('/editCandidatoSubmit', [MainController::class, 'editCandidatoSubmit'])->name('editCandidatoSubmit');

    // exluir candidato
    Route::get('/deleteCandidato/{id}', [MainController::class, 'deleteCandidato'])->name('deleteCandidato');
    Route::get('/deleteCandidatoConfirm/{id}', [MainController::class, 'deleteCandidatoConfirm'])->name('deleteCandidatoConfirm');

    // inscrição vaga
    Route::get('/inscreverVaga/{id}', [MainController::class, 'inscreverVaga'])->name('inscreverVaga');
    Route::get('/inscreverVagaConfirm/{id}', [MainController::class, 'inscreverVagaConfirm'])->name('inscreverVagaConfirm');

    // acessar vagas inscritas
    Route::get('/subscriptions', [MainController::class, 'subscriptions'])->name('subscriptions');

    // Cancelar inscrição na vaga
    Route::get('/cancelSubscription/{id}', [MainController::class, 'cancelSubscription'])->name('cancelSubscription');
    Route::get('/cancelSubscriptionConfirm/{id}', [MainController::class, 'cancelSubscriptionConfirm'])->name('cancelSubscriptionConfirm');


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
