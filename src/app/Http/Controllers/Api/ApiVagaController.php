<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vaga;
use Illuminate\Http\Request;
use App\Http\Requests\VagaRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\MassDeleteRequest;

/**
 * @group Vagas
 *
 * Endpoints para gerenciamento de vagas.
 */

class ApiVagaController extends Controller
{
    /**
     * Listar vagas
     *
     * Retorna uma lista de vagas com filtros opcionais e paginação.
     *
     * @queryParam tipo string Filtrar por tipo de vaga (CLT, PJ, Freelancer). Exemplo: CLT
     * @queryParam titulo string Buscar vagas pelo título. Exemplo: Desenvolvedor
     * @queryParam status string Status da vaga (ativa, inativa). Exemplo: ativa
     * @queryParam sort string Campo de ordenação. Exemplo: titulo
     * @queryParam direction string Direção da ordenação (asc ou desc). Exemplo: asc
     *
     * @response 200 {
     *   "success": true,
     *   "data": []
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);

        $vagas = Vaga::tipo($request->tipo)
            ->titulo($request->titulo)
            ->status($request->status)
            ->ordenar($request->sort, $request->get('direction', 'asc'))
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $vagas
        ], 200);
    }

    /**
     * Criar nova vaga
     *
     * @bodyParam titulo string required Título da vaga. Exemplo: Desenvolvedor PHP
     * @bodyParam descricao string required Descrição da vaga.
     * @bodyParam tipo string required Tipo da vaga (CLT, PJ, Freelancer).
     * @bodyParam salario number Valor do salário. Exemplo: 5500.00
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Vaga criada com sucesso!",
     *   "data": { "id": 1, "titulo": "Desenvolvedor PHP" }
     * }
     */
    public function store(VagaRequest $request): JsonResponse
    {
        $dados = $request->validated();

        // Verifica duplicidade (título + tipo)
        $existe = Vaga::where('titulo', $dados['titulo'])
                      ->where('tipo', $dados['tipo'])
                      ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Já existe uma vaga cadastrada com esse título e tipo.'
            ], 422);
        }

        $vaga = Vaga::create($dados);

        return response()->json([
            'success' => true,
            'data'    => $vaga
        ], 201);
    }

    /**
     * Mostrar detalhes de uma vaga
     *
     * @urlParam vaga int required ID da vaga. Exemplo: 1
     *
     * @response 200 {
     *   "success": true,
     *   "data": { "id": 1, "titulo": "Dev PHP" }
     * }
     */
    public function show(Vaga $vaga)
    {
        return response()->json([
            'success' => true,
            'data'    => $vaga
        ], 200);
    }

    /**
     * Atualizar vaga
     *
     * @urlParam vaga int required ID da vaga. Exemplo: 1
     * @bodyParam titulo string required Título da vaga.
     * @bodyParam descricao string required Descrição.
     * @bodyParam tipo string required Tipo da vaga (CLT, PJ, Freelancer).
     * @bodyParam salario number Salário.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Vaga atualizada com sucesso!",
     *   "data": { "id": 1, "titulo": "Dev PHP Senior" }
     * }
     */
    public function update(VagaRequest $request, Vaga $vaga): JsonResponse
    {
        $dados = $request->validated();

        // Verifica duplicidade (ignora a própria vaga)
        $existe = Vaga::where('titulo', $dados['titulo'])
                      ->where('tipo', $dados['tipo'])
                      ->where('id', '!=', $vaga->id)
                      ->exists();

        if ($existe) {
            return response()->json([
                'success' => false,
                'message' => 'Já existe uma vaga cadastrada com esse título e tipo.'
            ], 422);
        }

        $vaga->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Vaga atualizada com sucesso!',
            'data'    => $vaga
        ], 200);
    }

    /**
     * Deletar vaga
     *
     * @urlParam vaga int required ID da vaga. Exemplo: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Vaga excluída com sucesso."
     * }
     */
    public function destroy($id): JsonResponse
    {
        $vaga = Vaga::find($id);

        if (!$vaga) {
            return response()->json([
                'success' => false,
                'message' => 'Vaga não encontrada.'
            ], 404);
        }

        $vaga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vaga excluída com sucesso.',
            'id'      => $id
        ], 200);
    }

        /**
     * Excluir várias vagas de uma vez
     *
     * Recebe uma lista de IDs e exclui todas as vagas correspondentes.
     *
     * @bodyParam ids array required Lista de IDs das vagas a serem excluídas. Exemplo: [1, 2, 3]
     *
     * @response 200 {
     *   "success": true,
     *   "message": "3 vagas excluídas com sucesso.",
     *   "ids": [1, 2, 3]
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

    $deletados = \App\Models\Vaga::whereIn('id', $ids)->delete();

    if ($deletados === 0) {
        return response()->json([
            'success' => false,
            'message' => 'Nenhuma vaga encontrada para exclusão.',
            'ids'     => $ids
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => "$deletados vaga(s) excluída(s) com sucesso.",
        'ids'     => $ids
    ], 200);
}
}
