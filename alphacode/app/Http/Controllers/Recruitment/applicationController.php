<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class applicationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vaga_id' => 'required|exists:vagas,id',
            'candidato_id' => 'required|exists:candidatos,id',
        ]);

        if ($request->candidato_id != Auth::user()->candidato->id) {
            abort(403, 'Ação não autorizada. O candidato não corresponde ao usuário logado.');
        }

        $existingApplication = Application::where('candidato_id', $request->candidato_id)
                                         ->where('vaga_id', $request->vaga_id)
                                         ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'Você já se candidatou a esta vaga anteriormente.');
        }

        try {
            Application::create([
                'candidato_id' => $request->candidato_id,
                'vaga_id' => $request->vaga_id,
                'status' => 'pendente', 
            ]);

            return redirect()->back()->with('success', 'Sua candidatura foi enviada com sucesso!');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Erro ao candidatar-se: Você já enviou uma candidatura para esta vaga.');
            }
            return redirect()->back()->with('error', 'Ocorreu um erro ao processar sua candidatura. Tente novamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro inesperado: ' . $e->getMessage());
        }
    }

    public function show(Application $application)
    {
        $application->load(['candidato.user', 'vaga']);

         if (!Auth::user()->candidato || Auth::user()->candidato->id !== $application->candidato_id) {
            if (Auth::user()->candidato && Auth::user()->candidato->id !== $application->candidato_id) {
                abort(403, 'Você não tem permissão para visualizar esta candidatura.');
            }
        }

        return view('recruitment.show', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:pendente,em análise,aprovada,rejeitada', 
            'observacoes' => 'nullable|string|max:1000',
        ]);

        $application->update([
            'status' => $request->status,
            'observacoes' => $request->observacoes,
        ]);

        return redirect()->back()->with('success', 'Status da candidatura atualizado com sucesso!');
    }

    public function candidateIndex()
    {
        if (!Auth::user()->candidato) {
            return redirect()->route('dashboard')->with('error', 'Você não tem um perfil de candidato para visualizar candidaturas.');
        }

        $candidatoId = Auth::user()->candidato->id;

        $applications = Application::where('candidato_id', $candidatoId)
                                   ->with('vaga') 
                                   ->latest() 
                                   ->get();

        return view('candidate.recruitment.index', compact('applications'));
    }

}
