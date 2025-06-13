<?php

use App\Http\Controllers\Candidato\CandidatoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Recruitment\applicationController;
use App\Http\Controllers\Usuario\UserController;
use App\Http\Controllers\Vagas\VagaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('vagas.index');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::delete('/vagas/bulk-delete', [VagaController::class, 'bulkDelete'])->name('vagas.bulk-delete');
Route::resource('/vagas', VagaController::class);

Route::resource('/users', UserController::class);

Route::delete('/candidatos/bulk-destroy', [CandidatoController::class, 'bulkDestroy'])->name('candidatos.bulk_destroy');
Route::resource('/candidatos', CandidatoController::class);

Route::post('/applications', [applicationController::class, 'store'])->name('applications.store')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('applications', ApplicationController::class)->only([
        'show', 'store', 'update'
    ]);
});

Route::get('/my-applications', [ApplicationController::class, 'candidateIndex'])->name('applications.my-applications');



require __DIR__.'/auth.php';
