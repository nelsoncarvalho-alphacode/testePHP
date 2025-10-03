<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use Illuminate\Http\Request;
use App\Http\Requests\CandidatoRequest;
use App\Http\Requests\MassDeleteRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group Candidatos
 *
 * Endpoints para gerenciamento de candidatos.
 */
class ApiCandidatoController extends Controller
{
   /**
     * Listar candidatos
     *
     * Retorna candidatos com filtros opcionais.
     *
     * @queryParam nome string Nome parcial. Exemplo: João
     * @queryParam email string Email do candidato. Exemplo: joao@gmail.com
     * @queryParam telefone string Telefone. Exemplo: 11999999999
     *
     * @response 200 {
     *   "success": true,
     *   "data": []
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 20);

        $candidatos = Candidato::nome($request->nome)
            ->email($request->email)
            ->telefone($request->telefone)
            ->curriculo($request->curriculo)
            ->criadoEm($request->created_at)
            ->ordenar($request->sort, $request->get('direction', 'asc'))
            ->paginate($perPage);

            if ($candidatos->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Nenhum candidato encontrado para o filtro aplicado.',
                'data'    => $candidatos
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data'    => $candidatos
        ], 200);
    }

    /**
     * Criar candidato
     *
     * @bodyParam nome string required Nome completo. Exemplo: João da Silva
     * @bodyParam email string required Email único. Exemplo: joao@gmail.com
     * @bodyParam telefone string Telefone. Exemplo: 11999999999
     * @bodyParam curriculo string Link ou nome do arquivo. Exemplo: joao_cv.pdf
     * @bodyParam vagas array IDs das vagas a inscrever. Exemplo: [1,2]
     *
     * @response 201 {
     *   "success": true,
     *   "message": "Candidato cadastrado com sucesso!"
     * }
     */
    public function store(CandidatoRequest $request): JsonResponse
    {
        $dados = $request->validated();
        $vagas = $request->input('vagas', []);

        $cadastrado = Candidato::createCandidato($dados, $vagas);

        if (!$cadastrado) {
            // O próprio createCandidato já faz rollback e loga/reporta
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar candidato.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Candidato cadastrado com sucesso!',
        ], 201);
    }

    /**
     * Mostrar candidato
     *
     * @urlParam candidato int required ID do candidato. Exemplo: 1
     *
     * @response 200 {
     *   "success": true,
     *   "data": { "id": 1, "nome": "João da Silva" }
     * }
     */
    public function show(Candidato $candidato): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $candidato->load('vagas')
        ], 200);
    }

    /**
     * Atualizar candidato
     *
     * @urlParam candidato int required ID do candidato. Exemplo: 1
     * @bodyParam nome string required Nome completo.
     * @bodyParam email string required Email único.
     * @bodyParam telefone string Telefone.
     * @bodyParam curriculo string Currículo.
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Candidato atualizado com sucesso!"
     * }
     */
    public function update(CandidatoRequest $request, Candidato $candidato): JsonResponse
    {
        // Validação centralizada no FormRequest
        $dados = $request->validated();

        // Atualização
        $candidato->update($dados);

        return response()->json([
            'success' => true,
            'message' => 'Candidato atualizado com sucesso!',
            'data'    => $candidato
        ], 200);
    }

    /**
     * Excluir candidato
     *
     * @urlParam candidato int required ID do candidato. Exemplo: 1
     *
     * @response 200 {
     *   "success": true,
     *   "message": "Candidato excluído com sucesso."
     * }
     */
    public function destroy($id): JsonResponse
{
    // Tenta encontrar o candidato
    $candidato = Candidato::find($id);

    // Se não encontrar, retorna 404
    if (!$candidato) {
        return response()->json([
            'success' => false,
            'message' => 'Candidato não encontrado.'
        ], 404);
    }

    // Exclui o candidato
    $candidato->delete();

    return response()->json([
        'success' => true,
        'message' => 'Candidato excluído com sucesso.',
        'id'      => $id
    ], 200);
}

    /**
     * Excluir vários candidatos de uma vez
     *
     * Recebe uma lista de IDs e exclui todos os candidatos correspondentes.
     *
     * @bodyParam ids array required Lista de IDs dos candidatos a serem excluídos. Exemplo: [5, 6, 7]
     *
     * @response 200 {
     *   "success": true,
     *   "message": "3 candidatos excluídos com sucesso.",
     *   "ids": [5, 6, 7]
     * }
     *
     * @response 400 {
     *   "success": false,
     *   "message": "Nenhum ID informado."
     * }
     *
     * @response 404 {
     *   "success": false,
     *   "message": "Nenhum candidato encontrado para exclusão.",
     *   "ids": [99, 100]
     * }
     */
    public function destroyMass(MassDeleteRequest $request): JsonResponse
{
    $ids = $request->validated()['ids'];

    $deletados = \App\Models\Candidato::whereIn('id', $ids)->delete();

    if ($deletados === 0) {
        return response()->json([
            'success' => false,
            'message' => 'Nenhum candidato encontrado para exclusão.',
            'ids'     => $ids
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => "$deletados candidato(s) excluído(s) com sucesso.",
        'ids'     => $ids
    ], 200);
}


}
