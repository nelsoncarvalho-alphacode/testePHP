<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'O nome da categoria é obrigatório.',
            'name.max' => 'O nome da categoria não pode ter mais de 255 caracteres.'
        ]);

        $this->createCategorie($validatedData);

        return redirect()->route('categories.index')->with('success', 'Categoria adicionada com sucesso.');
    }

    protected function createCategorie(array $data)
    {
        return Categorie::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categorie::destroy($id);
        return redirect()->route('categories.index')->with('success', 'Categoria deletada com sucesso.');
    }
}
