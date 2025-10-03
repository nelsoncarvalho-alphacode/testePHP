<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\VagaRequest;

class VagaController extends Controller
{
    /**
     * Lista todas as vagas com paginação.
     *
     * @return View
     */
    public function index(): View
    {
        // Paginação de 20 vagas por página
        $vagas = Vaga::paginate(10);

        // Retorna a view index de vagas com os dados
        return view('vagas.index', compact('vagas'));
    }

    /**
     * Exibe o formulário de criação de nova vaga.
     *
     * @return View
     */
    public function create(): View
    {
        return view('vagas.create');
    }

    /**
     * Salva uma nova vaga no banco de dados.
     *
     * @param  VagaRequest  $request
     * @return RedirectResponse
     */
    public function store(VagaRequest $request): RedirectResponse
    {
        // Cria a vaga usando apenas os dados validados
        Vaga::create($request->validated());

        // Redireciona para a lista de vagas com mensagem de sucesso
        return redirect()
        ->route('vagas.index')
        ->with('success', 'Vaga cadastrada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma vaga específica.
     *
     * @param  Vaga  $vaga
     * @return View
     */
    public function show(Vaga $vaga): View
    {  $vaga->load('candidatos');
       return view('vagas.show', compact('vaga'));
    }

    /**
     * Exibe o formulário de edição de uma vaga existente.
     *
     * @param  Vaga  $vaga
     * @return View
     */
    public function edit(Vaga $vaga): View
    {
        return view('vagas.edit', compact('vaga'));
    }

    /**
     * Atualiza os dados de uma vaga no banco.
     *
     * @param  VagaRequest  $request
     * @param  Vaga  $vaga
     * @return RedirectResponse
     */
    public function update(VagaRequest $request, Vaga $vaga): RedirectResponse
    {
        // Atualiza somente os dados validados
        $vaga->update($request->validated());

        // Redireciona para a lista com mensagem de sucesso
        return redirect()
        ->route('vagas.index')
        ->with('success', 'Vaga atualizada com sucesso!');
    }

    /**
     * Remove uma vaga do banco de dados.
     *
     * @param  Vaga  $vaga
     * @return RedirectResponse
     */
    public function destroy(Vaga $vaga): RedirectResponse
    {
        $vaga->delete();

        // Redireciona para a lista com mensagem de sucesso
        return redirect()
        ->route('vagas.index')
        ->with('success', 'Vaga deletada com sucesso!');
    }
}
