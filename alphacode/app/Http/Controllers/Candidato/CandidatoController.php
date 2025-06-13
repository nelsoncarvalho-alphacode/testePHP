<?php

namespace App\Http\Controllers\Candidato;

use App\Http\Controllers\Controller;
use App\Http\Requests\candidato\StoreCandidatoRequest;
use App\Http\Requests\Candidato\UpdateCandidatoRequest;
use App\Models\Candidato;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 

class CandidatoController extends Controller
{
    public function index(Request $request) 
    {
        try {
            $query = Candidato::with('user')
                               ->orderBy('created_at', 'desc');

            if ($request->filled('search')) {
                $searchTerm = $request->input('search');
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('cpf', 'like', '%' . $searchTerm . '%')
                      ->orWhere('telefone', 'like', '%' . $searchTerm . '%')
                      ->orWhere('endereco', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function ($uq) use ($searchTerm) {
                          $uq->where('name', 'like', '%' . $searchTerm . '%')
                             ->orWhere('email', 'like', '%' . $searchTerm . '%');
                      });
                });
            }

            if ($request->filled('formacao_filter') && $request->input('formacao_filter') !== '') {
                $query->where('formacao', 'like', '%' . $request->input('formacao_filter') . '%');
            }

            if ($request->filled('habilidade_filter') && $request->input('habilidade_filter') !== '') {
                $query->where('habilidades', 'like', '%' . $request->input('habilidade_filter') . '%');
            }

            $candidatos = $query->paginate(10);

            $candidatos->appends($request->except('page'));

            return view('candidatos.index', compact('candidatos', 'request'));

        } catch (\Exception | \Error $e) {
            Log::error('Erro ao listar candidatos: ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return redirect()->route('dashboard')->with('error', 'Ocorreu um erro ao carregar a lista de candidatos.');
        }
    }

    public function create()
    {
        $users = User::doesntHave('candidato')->get();

        return view('candidatos.create', compact('users'));
    }

     public function store(StoreCandidatoRequest $request)
    {
        try {
   
            $candidato = Candidato::create($request->validated());

            return redirect()->route('candidatos.index')->with('success', 'Candidato criado com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao criar candidato: ' . $e->getMessage());
    
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao criar o candidato. Tente novamente.');
        }
    }

    public function show(Candidato $candidato) 
    {
        try {
        
            $candidato->loadMissing('user');

            return view('candidatos.show', compact('candidato'));

        } catch (\Exception | \Error $e) {
            Log::error('Erro ao exibir detalhes do candidato (ID: ' . $candidato->id . '): ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return redirect()->route('candidatos.index')->with('error', 'Ocorreu um erro ao carregar os detalhes do candidato.');
        }
    }

     public function edit(Candidato $candidato)
    {
        try {
            $candidato->loadMissing('user');

            $users = User::doesntHave('candidato')
                        ->orWhere('id', $candidato->user_id)
                        ->get();

            return view('candidatos.edit', compact('candidato', 'users'));

        } catch (\Exception | \Error $e) {
            Log::error('Erro ao exibir formulário de edição do candidato (ID: ' . $candidato->id . '): ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return redirect()->route('candidatos.index')->with('error', 'Ocorreu um erro ao carregar o formulário de edição do candidato.');
        }
    }

    public function update(UpdateCandidatoRequest $request, Candidato $candidato) 
    {
        try {
            $candidato->update($request->validated());

            return redirect()->route('candidatos.show', $candidato)->with('success', 'Candidato atualizado com sucesso!');

        } catch (\Exception | \Error $e) {
            Log::error('Erro ao atualizar candidato (ID: ' . $candidato->id . '): ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
    
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar o candidato. Tente novamente.');
        }
    }
    
     public function destroy(Candidato $candidato) 
    {
        try {
            $candidato->delete();

            return redirect()->route('candidatos.index')->with('success', 'Candidato excluído com sucesso!');

        } catch (\Exception | \Error $e) {
            Log::error('Erro ao excluir candidato (ID: ' . $candidato->id . '): ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir o candidato. Tente novamente.');
        }
    }

     public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:candidatos,id', 
        ]);

        try {
            DB::beginTransaction(); 

            $candidatoIds = $request->input('ids');

            Candidato::whereIn('id', $candidatoIds)->delete();

            DB::commit(); 

            return redirect()->route('candidatos.index')->with('success', 'Candidatos selecionados excluídos com sucesso!');

        } catch (\Exception | \Error $e) {
            DB::rollBack(); 
            Log::error('Erro ao excluir candidatos em massa: ' . $e->getMessage() . ' no arquivo ' . $e->getFile() . ' na linha ' . $e->getLine());
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir os candidatos selecionados. Tente novamente.');
        }
    }
}
