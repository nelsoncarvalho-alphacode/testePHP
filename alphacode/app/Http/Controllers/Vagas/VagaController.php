<?php

namespace App\Http\Controllers\Vagas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vaga\BulkDeleteVagaRequest;
use App\Http\Requests\Vaga\StoreVagaRequest;
use App\Http\Requests\Vaga\UpdateVagaRequest;
use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class VagaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Vaga::query();

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('titulo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
        }

        if ($request->has('tipo_vaga') && $request->input('tipo_vaga') != '') {
            $query->where('tipo_vaga', $request->input('tipo_vaga'));
        }

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('ativa', $request->input('status') == 'ativa');
        }

        $orderBy = $request->input('order_by', 'created_at');
        $direction = $request->input('direction', 'desc');

        $allowedOrderBy = ['id', 'titulo', 'tipo_vaga', 'ativa', 'created_at'];
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'created_at';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $query->orderBy($orderBy, $direction);

        $perPage = $request->input('per_page', 20);
        $vagas = $query->paginate($perPage);

        return view('vagas.index', compact('vagas', 'request'));
    }

    public function create()
    {
        Gate::authorize('create', Vaga::class);
        return view('vagas.create');
    }

    public function store(StoreVagaRequest $request)
    {
        Gate::authorize('create', Vaga::class);
        Vaga::create($request->validated());

        return redirect()->route('vagas.index')->with('success', 'Vaga criada com sucesso!');
    }

    public function show(Vaga $vaga)
    {
        $vaga->load(['applications.candidato.user']);

        return view('vagas.show', compact('vaga'));
    }

    public function edit(Vaga $vaga)
    {
        Gate::authorize('update', $vaga);
        return view('vagas.edit', compact('vaga'));
    }

    public function update(UpdateVagaRequest $request, Vaga $vaga)
    {
        Gate::authorize('update', $vaga);
        $vaga->update($request->validated());

        return redirect()->route('vagas.index')->with('success', 'Vaga atualizada com sucesso');
    }

    public function destroy(Vaga $vaga)
    {
        Gate::authorize('delete', $vaga);
        try {
            $vaga->delete();
            return redirect()->route('vagas.index')->with('success', 'Vaga excluída com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir vaga ' . $vaga->id . ': ' . $e->getMessage());
            return redirect()->route('vagas.index')->with('error', 'Não foi possível excluir a vaga. Ela pode ter candidatos associados ou outro problema.');
        }
    }

    public function bulkDelete(BulkDeleteVagaRequest $request)
    {
        Gate::authorize('delete', Vaga::class);

        $vagaIds = $request->validated('vaga_ids');

        try {
            DB::beginTransaction();

            Vaga::whereIn('id', $vagaIds)->delete();

            DB::commit();

            return redirect()->route('vagas.index')->with('success', 'Vagas selecionadas excluídas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir vagas em massa: ' . $e->getMessage());
            return redirect()->route('vagas.index')->with('error', 'Ocorreu um erro ao excluir as vagas selecionadas. Tente Novamente');
        }
    }
}

