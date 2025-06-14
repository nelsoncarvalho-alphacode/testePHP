<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidato;
use App\Models\Vaga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class applicationController extends Controller
{
   public function store(Request $request)
    {
        $request->validate([
            'vaga_id' => 'required|exists:vagas,id',
            'candidato_id' => 'required|exists:candidatos,id',
        ]);

        if (Auth::user()?->candidato?->id != $request->candidato_id) {
            abort(403, 'Você não tem permissão para submeter candidaturas por outro candidato.');
        }

        $vaga = Vaga::find($request->vaga_id);
        $candidato = Candidato::find($request->candidato_id);

        if (!$vaga->ativa) {
            return redirect()->back()->with('error', 'Não é possível candidatar-se a uma vaga inativa.');
        }

        if ($candidato->applications()->where('vaga_id', $vaga->id)->exists()) {
            return redirect()->back()->with('error', 'Você já se candidatou a esta vaga.');
        }

        try {
            Application::create([
                'vaga_id' => $vaga->id,
                'candidato_id' => $candidato->id,
                'status' => 'em_analise', // Status inicial
            ]);

            return redirect()->back()->with('success', 'Candidatura enviada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao submeter candidatura: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao enviar sua candidatura.');
        }
    }

    public function show(Application $application)
    {
        Gate::authorize('view', $application);

        $application->load('vaga', 'candidato.user');
        return view('applications.show', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        Gate::authorize('update', $application);

        try {
            $request->validate([
                'status' => 'required|in:em_analise,aprovado,rejeitado',
            ]);

            $application->update([
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Status da candidatura atualizado com sucesso!');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar status da candidatura ' . $application->id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o status da candidatura.');
        }
    }
    

    public function myApplications()
    {
        if (!Auth::check() || !Auth::user()->candidato) {
            abort(403, 'Você não possui um perfil de candidato para ver suas candidaturas.');
        }

        $candidatoId = Auth::user()->candidato->id;
        $applications = Application::where('candidato_id', $candidatoId)
                                   ->with('vaga')
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(10);

        return view('applications.my-applications', compact('applications'));
    }

}
