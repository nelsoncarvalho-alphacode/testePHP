<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\VagaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\InscricaoController;

// Página inicial redireciona para login
//Route::get('/', function () {
 //   return redirect()->route('login');
//});


// Rotas apenas para visitantes (guest)
Route::middleware('guest')->group(function () {

    Route::get('/', function () {
    return redirect()->route('login');
   });

    // Registro
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    // Login
    Route::get('/login', [AuthenticationController::class, 'login'])->name('login.form');
    Route::post('/login', [AuthenticationController::class, 'logar'])->name('login');

    // Esqueci minha senha
    Route::get('/forget-password', [PasswordResetController::class, 'request'])->name('password.request');
    Route::post('/forget-password', [PasswordResetController::class, 'email'])->name('password.email');

    // Resetar senha
    Route::get('/reset-password', [PasswordResetController::class, 'reset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

});


// Rotas apenas para usuários autenticados (auth)
Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Logout
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    // Vagas
    Route::resource('vagas', VagaController::class);

    // Candidatos
    Route::resource('candidatos', CandidatoController::class);

    // Inscrições
    Route::resource('inscricoes', InscricaoController::class)
        ->parameters(['inscricoes' => 'inscricao']);
});
