<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VagaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Vaga::query();

        if ($request->filled('filtro_titulo')) {
            $query->where('titulo', 'like', '%' . $request->filtro_titulo . '%');
        }

        if ($request->filled('ordenar_por')) {
            $query->orderBy($request->ordenar_por, $request->direction);
        }

        $itensPorPagina = $request->input('itens_por_pagina', 10);
        $vagas = $query->paginate($itensPorPagina);
        $candidatoId = Auth::id();

        return view('vagas.index', compact('vagas', 'candidatoId'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vagas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vaga = new Vaga();
        $vaga->titulo = $request->titulo;
        $vaga->descricao = $request->descricao;
        $vaga->tipo = $request->tipo;
        $vaga->save();

        return redirect()->route('vagas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vaga = Vaga::findOrFail($id);
        return view('vagas.edit', compact('vaga'));
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
        $vaga = Vaga::findOrFail($id);
        $vaga->titulo = $request->input('titulo');
        $vaga->descricao = $request->input('descricao');
        $vaga->tipo = $request->input('tipo');
        $vaga->save();

        return redirect()->route('vagas.index')->with('success', 'Vaga atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->delete();

        return redirect()->route('vagas.index')->with('success', 'Vaga excluída com sucesso!');
    }

    public function deletarEmMassa(Request $request)
    {
        $request->validate([
            'vagas_ids' => 'required|array',
            'vagas_ids.*' => 'exists:vagas,id',
        ]);

        $vagasIds = $request->input('vagas_ids');

        Vaga::whereIn('id', $vagasIds)->delete();

        return redirect()->route('vagas.index')->with('success', 'Vagas selecionadas foram deletadas com sucesso!');
    }

    public function pausar($id)
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->pausada = true;
        $vaga->save();

        return redirect()->route('vagas.index')->with('success', 'Vaga pausada com sucesso!');
    }
}
