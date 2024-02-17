<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use App\Models\Vaga;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Candidato::query();

        if ($request->filled('filtro_nome')) {
            $query->where('nome', 'like', '%' . $request->filtro_nome . '%');
        }

        if ($request->filled('ordenar_por')) {
            $query->orderBy($request->ordenar_por, $request->direction);
        }

        $itensPorPagina = $request->input('itens_por_pagina', 10);
        $candidatos = $query->withCount('vagas')->paginate($itensPorPagina);

        return view('candidatos.index', compact('candidatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidatos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:candidatos',
            'telefone' => 'required',
            'qtdExp' => 'required|integer',
            'linguagens' => 'required',
            'formacao' => 'required|in:Ensino Médio Completo,Ensino Superior Em Andamento,Ensino Superior Completo'
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
            'unique' => 'O :attribute já está sendo utilizado.',
            'in' => 'O campo :attribute deve ser uma das opções especificadas.'
        ]);

        Candidato::create($request->all());

        return redirect()->route('candidatos.index')->with('success', 'Candidato criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidato = Candidato::findOrFail($id);
        return view('candidatos.edit', compact('candidato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:candidatos,email,' . $id,
            'telefone' => 'required',
            'qtdExp' => 'required|integer',
            'linguagens' => 'required',
            'formacao' => 'required|in:Ensino Médio Completo,Ensino Superior Em Andamento,Ensino Superior Completo'
        ], [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido e único.',
            'in' => 'O campo :attribute deve ser uma das opções especificadas.'
        ]);

        $candidato = Candidato::findOrFail($id);
        $candidato->update($request->all());

        return redirect()->route('candidatos.index')->with('success', 'Candidato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidato = Candidato::findOrFail($id);
        $candidato->delete();

        return redirect()->route('candidatos.index')->with('success', 'Candidato excluído com sucesso!');
    }

    public function deletarEmMassa(Request $request)
    {
        $request->validate([
            'candidatos_ids' => 'required|array',
            'candidatos_ids.*' => 'exists:candidatos,id',
        ]);

        $candidatosIds = $request->input('candidatos_ids');

        Candidato::whereIn('id', $candidatosIds)->delete();

        return redirect()->route('candidatos.index')->with('success', 'Candidatos selecionados foram deletados com sucesso!');
    }

    public function inscrever(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            'email' => 'required|email',
            'vaga_id' => 'required',
        ]);

        $candidato = Candidato::where('nome', $request->nome)
            ->where('telefone', $request->telefone)
            ->where('email', $request->email)
            ->first();

        if (!$candidato) {
            return redirect()->back()->withInput()->withErrors(['nome' => 'Candidato não cadastrado no sistema.']);
        }

        $vagaId = $request->vaga_id;
        $candidato->vagas()->attach($vagaId);

        return redirect()->back()->with('success', 'Inscrição realizada com sucesso!');
    }
}
