<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga;
use App\Models\Inscricao;
use App\Models\Candidato;
class HomeController extends Controller
{

   public function index()
{
    $totalVagas = Vaga::count();
    $totalCandidatos = Candidato::count();
    $totalInscricoes = Inscricao::count();

    // pegar últimos registros de cada entidade
    $ultimasVagas = Vaga::latest()->take(1)->get();
    $ultimosCandidatos = Candidato::latest()->take(1)->get();
    $ultimaInscricao = Inscricao::with(['candidato', 'vaga'])
    ->orderByDesc('data_inscricao')
    ->first();

    return view('home.index', compact(
        'totalVagas',
        'totalCandidatos',
        'totalInscricoes',
        'ultimasVagas',
        'ultimosCandidatos',
        'ultimaInscricao'
    ));
}

}

