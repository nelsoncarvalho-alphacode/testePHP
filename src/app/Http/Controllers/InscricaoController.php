<?php

namespace App\Http\Controllers;

use App\Models\Inscricao;
use App\Models\Candidato;
use App\Models\Vaga;
use App\Http\Requests\InscricaoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class InscricaoController extends Controller
{
    /**
     * Lista todas as inscrições (com candidato e vaga relacionados).
     */
    public function index()
    {
        $inscricoes = Inscricao::with(['candidato', 'vaga'])->paginate(20);

        return view('inscricoes.index', compact('inscricoes'));
    }

    /**
     * Formulário de criação de inscrição.
     */
    public function create()
    {
        $candidatos = Candidato::all();
        $vagas = Vaga::where('status', 'ativa')->get(); // apenas vagas ativas

        return view('inscricoes.create', compact('candidatos', 'vagas'));
    }

    /**
     * Cria uma nova inscrição.
     */
    public function store(InscricaoRequest $request): RedirectResponse
    {
        $ok = Inscricao::createInscricao($request->validated());

        if (!$ok) {
            return redirect()
            ->back()
            ->withErrors(['vaga_id' => 'Este candidato já está inscrito nesta vaga ou ocorreu um erro.'])
            ->withInput();
        }

        return redirect()
        ->route('inscricoes.index')
        ->with('success', 'Inscrição criada com sucesso!');
    }

    /**
     * Exibe uma inscrição específica (não implementado).
     */
    public function show(Inscricao $inscricao)
    {
        // Carregar candidato e vaga juntos
        $inscricao->load(['candidato', 'vaga']);

        return view('inscricoes.show', compact('inscricao'));
    }

    /**
     * Formulário de edição da inscrição.
     */
    public function edit(Inscricao $inscricao)
    {
        $candidatos = Candidato::all();
        $vagas = Vaga::where('status', 'ativa')->get();

        return view('inscricoes.edit', compact('inscricao', 'candidatos', 'vagas'));
    }

    /**
     * Atualiza os dados de uma inscrição existente.
     */
    public function update(InscricaoRequest $request, Inscricao $inscricao): RedirectResponse
    {
        $ok = $inscricao->atualizarInscricao($request->validated());

        if (!$ok) {
            return redirect()
            ->back()
            ->withErrors(['vaga_id' => 'Este candidato já está inscrito nesta vaga ou ocorreu um erro.'])
            ->withInput();
        }

        return redirect()
        ->route('inscricoes.index')
        ->with('success', 'Inscrição atualizada com sucesso!');
    }

    /**
     * Remove uma inscrição do banco.
     */
    public function destroy(Inscricao $inscricao): RedirectResponse
    {
        $inscricao->delete();

        return redirect()
        ->route('inscricoes.index')
        ->with('success', 'Inscrição deletada com sucesso!');
    }
}
