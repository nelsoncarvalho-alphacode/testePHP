<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inscricao;
use App\Http\Requests\InscricaoRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group Inscrições
 *
 * Endpoints para gerenciar as inscrições de candidatos em vagas.
 */
class ApiInscricaoController extends Controller
{
    /**
     * Listar inscrições
     *
     * Retorna todas as inscrições com filtros opcionais.
     *
     * @queryParam candidato_id int ID do candidato. Exemplo: 1
     * @queryParam vaga_id int ID da vaga. Exemplo: 2
     *
     * @response 200 {
     *   "success": true,
     *   "data": []
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);

        $inscricoes = Inscricao::with(['candidato', 'vaga'])
            ->candidato($request->candidato_id)
            ->vaga($request->vaga_id)
            ->dataInscricao($request->data_inscricao)
            ->ordenar($request->sort, $request->get('direction', 'asc'))
            ->paginate($perPage);

        if ($inscricoes->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Nenhuma inscrição encontrada para o filtro aplicado.',
                'data'    => $inscricoes
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data'    => $inscricoes
        ], 200);
    }

    /**
     * Criar inscrição
     *
     * @bodyParam candidato_id int required ID do candidato. Exemplo: 1
     * @bodyParam vaga_id int required ID da vaga. Exemplo: 2
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Inscrição criada com sucesso!"
     * }
     */
    public function store(InscricaoRequest $request): JsonResponse
    {
        $criada = Inscricao::createInscricao($request->validated());

        if (!$criada) {
            return response()->json([
                'success' => false,
                'message' => 'Este candidato já está inscrito nesta vaga ou ocorreu um erro.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inscrição criada com sucesso!'
        ], 201);
    }

    /**
     * Mostrar inscrição
     *
     * @urlParam inscricao int required ID da inscrição. Exemplo: 5
     *
     * @response 200 {
     *   "success": true,
     *   "data": { "id": 5, "candidato_id": 1, "vaga_id": 2 }
     * }
     */
    public function show(Inscricao $inscricao): JsonResponse
    {
    // Carrega relações candidato e vaga
    // Carrega relações candidato e vaga
    $inscricao->load(['candidato', 'vaga']);

    // Se candidato ou vaga não existirem (chave inválida), trata como erro
    if (is_null($inscricao->candidato) || is_null($inscricao->vaga)) {
        return response()->json([
            'success' => false,
            'message' => 'Inscrição encontrada, mas o candidato ou a vaga associados não existem mais.',
            'data'    => $inscricao
        ], 422);
    }

    // Retorno padronizado quando tudo está ok
    return response()->json([
        'success' => true,
        'message' => 'Inscrição encontrada com sucesso!',
        'data'    => $inscricao
    ], 200);
    }

   /**
     * Atualizar inscrição
     *
     * @urlParam inscricao int required ID da inscrição. Exemplo: 5
     * @bodyParam candidato_id int required ID do candidato.
     * @bodyParam vaga_id int required ID da vaga.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Inscrição atualizada com sucesso!"
     * }
     */
    public function update(InscricaoRequest $request, Inscricao $inscricao): JsonResponse
    {
        $atualizada = $inscricao->atualizarInscricao($request->validated());

        if (!$atualizada) {
            return response()->json([
                'success' => false,
                'message' => 'Este candidato já está inscrito nesta vaga ou ocorreu um erro.'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inscrição atualizada com sucesso!',
            'data'    => $inscricao->load(['candidato', 'vaga'])
        ], 200);
    }

    /**
     * Excluir inscrição
     *
     * @urlParam inscricao int required ID da inscrição. Exemplo: 5
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Inscrição excluída com sucesso."
     * }
     */
    public function destroy(Inscricao $inscricao): JsonResponse
    {
        $id = $inscricao->id;

        $inscricao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inscrição excluída com sucesso.',
            'id'      => $id
        ], 200);
    }

    /**
     * Excluir várias inscrições de uma vez
     *
     * Recebe uma lista de IDs e exclui todas as inscrições correspondentes.
     *
     * @bodyParam ids array required Lista de IDs das inscrições a serem excluídas. Exemplo: [10, 11, 12]
     *
     * @response 200 {
     *   "success": true,
     *   "message": "3 inscrições excluídas com sucesso.",
     *   "ids": [10, 11, 12]
     * }
     *
     * @response 400 {
     *   "success": false,
     *   "message": "Nenhum ID informado."
     * }
     */
    public function destroyMass(MassDeleteRequest $request): JsonResponse
{
    $ids = $request->validated()['ids'];

    $deletados = \App\Models\Inscricao::whereIn('id', $ids)->delete();

    if ($deletados === 0) {
        return response()->json([
            'success' => false,
            'message' => 'Nenhuma inscrição encontrada para exclusão.',
            'ids'     => $ids
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => "$deletados inscrição(ões) excluída(s) com sucesso.",
        'ids'     => $ids
    ], 200);
}

}
