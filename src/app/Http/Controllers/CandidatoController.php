<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Vaga;
use App\Http\Requests\CandidatoRequest;
use Illuminate\Http\RedirectResponse;

class CandidatoController extends Controller
{
    /**
     * Lista todos os candidatos com suas vagas relacionadas (paginação).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $candidatos = Candidato::with('vagas')->paginate(10);

        return view('candidatos.index', compact('candidatos'));
    }

    /**
     * Mostra o formulário de criação de candidato.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $vagas = Vaga::where('status', 'ativa')->get(); // apenas vagas ativas

        return view('candidatos.create', compact('vagas'));
    }

    /**
     * Salva um novo candidato no banco de dados.
     *
     * @param  CandidatoRequest  $request
     * @return RedirectResponse
     */
    public function store(CandidatoRequest $request): RedirectResponse
    {
        $validaCadastro = Candidato::createCandidato(
            $request->validated(),
            $request->input('vagas', [])
        );

        if (!$validaCadastro) {
            return redirect()
            ->back()
            ->withErrors(['error' => 'Erro ao cadastrar candidato.']);
        }

        return redirect()
        ->route('candidatos.index')
        ->with('success', 'Candidato cadastrado com sucesso!');
    }

    /**
     * Exibe detalhes de um candidato específico (não implementado).
     *
     * @param  Candidato  $candidato
     * @return void
     */
    public function show(Candidato $candidato)
    {
        // Carrega também as vagas relacionadas com a data de inscrição
        $candidato->load('vagas');

        return view('candidatos.show', compact('candidato'));
    }


    /**
     * Mostra o formulário para edição de um candidato.
     *
     * @param  Candidato  $candidato
     * @return \Illuminate\View\View
     */
    public function edit(Candidato $candidato)
{
    // carrega o relacionamento para popular os checkboxes
    $candidato->load('vagas');

    // apenas vagas ativas
    $vagas = Vaga::where('status', 'ativa')->get();

    return view('candidatos.edit', compact('candidato', 'vagas'));
}



    /**
     * Atualiza os dados de um candidato existente.
     *
     * @param  CandidatoRequest  $request
     * @param  Candidato         $candidato
     * @return RedirectResponse
     */
    public function update(CandidatoRequest $request, Candidato $candidato): RedirectResponse
{
    $validaUpdate = $candidato->atualizarCandidato($request->validated());

    if (!$validaUpdate) {
        return redirect()
            ->back()
            ->withErrors(['error' => 'Erro ao atualizar candidato.']);
    }

    // Sincroniza as vagas marcadas no formulário
    $candidato->vagas()->sync($request->input('vagas', []));

    return redirect()
        ->route('candidatos.index')
        ->with('success', 'Candidato atualizado com sucesso!');
}

    /**
     * Remove um candidato do banco de dados.
     *
     * @param  Candidato  $candidato
     * @return RedirectResponse
     */
    public function destroy(Candidato $candidato): RedirectResponse
    {
        $candidato->delete();

        return redirect()
        ->route('candidatos.index')
        ->with('success', 'Candidato deletado com sucesso!');
    }
}
