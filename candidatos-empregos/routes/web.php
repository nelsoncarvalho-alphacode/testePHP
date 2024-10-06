<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\VagasController;


// Rotas dos candidatos na aplicação.

Route::get('/candidatos', function() {

    $candidatos_controller = new CandidatoController();
    $candidatos = $candidatos_controller->candidatos();
    return json_encode($candidatos);

});

Route::get('/candidato/{id}', function(int $id) {

    $candidatos_controller = new CandidatoController();
    $candidato = $candidatos_controller->candidato($id);
    return json_encode($candidato);

});

Route::post('/candidato/cadastro', function(Request $request) {

    $candidato_dados = $request->json()->all();
    $candidato_controller = new CandidatoController();

    $response = $candidato_controller->cadastro($candidato_dados);
    return json_encode($response);

});

Route::post('/candidato/login', function(Request $request) {

    $candidato_dados = $request->json()->all();
    $candidato_controller = new CandidatoController();

    $response = $candidato_controller->login($candidato_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::put('/candidato/editar', function(Request $request) {

    $candidato_dados = $request->json()->all();
    $candidato_controller = new CandidatoController();

    $response = $candidato_controller->editar($candidato_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::delete('/candidato/excluir/conta/{id}', function(int $id) {

    $candidato = $id;
    $candidato_controller = new CandidatoController();

    $response = $candidato_controller->excluir_conta($candidato);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});


// Rotas das empresas na aplicação.


Route::get('/empresas', function() {

    $empresas_controller = new EmpresasController();
    $empresas = $empresas_controller->empresas();
    return json_encode($empresas);

});

Route::get('/empresa/{id}', function(int $id) {

    $empresas_controller = new EmpresasController();
    $empresa = $empresas_controller->empresa($id);
    return json_encode($empresa);

});

Route::get('/empresa/vagas/{id}', function(int $id) {

    $empresas_controller = new EmpresasController();
    $empresa_vagas = $empresas_controller->empresa_vagas($id);
    return json_encode($empresa_vagas);

});

Route::post('/empresa/cadastro', function(Request $request) {

    $empresa_dados = $request->json()->all();
    $empresas_controller = new EmpresasController();

    $response = $empresas_controller->cadastro($empresa_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::post('/empresa/login', function(Request $request) {

    $empresa_dados = $request->json()->all();
    $empresas_controller = new EmpresasController();

    $response = $empresas_controller->login($empresa_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::put('/empresa/editar', function(Request $request) {

    $empresa_dados = $request->json()->all();
    $empresas_controller = new EmpresasController();

    $response = $empresas_controller->editar($empresa_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::delete('/empresa/excluir/conta/{id}', function(int $id) {

    $empresa = $id;
    $empresas_controller = new EmpresasController();

    $response = $empresas_controller->excluir_conta($empresa);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});


// Rotas de vagas na aplicação.

Route::get('/vagas', function() {

    $vagas_controller = new VagasController();
    $vagas = $vagas_controller->vagas();
    return json_encode($vagas);

});

Route::get('/vaga/{id}', function(int $id) {

    $vagas_controller = new VagasController();
    $vaga = $vagas_controller->vaga($id);
    return json_encode($vaga);

});


Route::post('/vaga/cadastro', function(Request $request) {

    $vaga_dados = $request->json()->all();
    $vagas_controller = new VagasController();

    $response = $vagas_controller->cadastro($vaga_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::put('/vaga/editar', function(Request $request) {

    $vaga_dados = $request->json()->all();
    $vagas_controller = new VagasController();

    $response = $vagas_controller->editar($vaga_dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

});

Route::delete('/vaga/excluir/{id}', function(int $id) {

    $vagas_controller = new VagasController();
    $response = $vagas_controller->excluir_vaga($id);
    return json_encode($response, JSON_UNESCAPED_UNICODE);


});

Route::post('/vaga/candidatar', function(Request $request) {

    $dados = $request->json()->all(); 
    $vagas_controller = new VagasController();

    $response = $vagas_controller->candidatar($dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);


});

Route::delete('/vaga/remover/candidatura', function(Request $request) {

    $dados = $request->json()->all(); 
    $vagas_controller = new VagasController();

    $response = $vagas_controller->remover_candidatura($dados);
    return json_encode($response, JSON_UNESCAPED_UNICODE);

    $dados = $request->json()->all();
    return json_encode($dados);

});


// Rotas de redirecionamento da interface da aplicação.

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cadastro', function(){
    return view('cadastro');
});

Route::get('/empresa/{id}', function(int $id){
    
    $empresas_controller = new EmpresasController();
    $empresa_dados = $empresas_controller->empresa($id);
    return view('empresa', ['empresa_dados' => $empresa_dados]);

});

Route::get('/candidato/{id}', function(int $id){
    
    $candidato_controller = new CandidatoController();
    $candidato_dados = $candidato_controller->candidato($id);
    return view('candidato', ['candidato_dados' => $candidato_dados]);

});

Route::get('/cadastro/vaga', function(){
    return view('cadastro-vaga');
});

Route::get('/vagas/candidato/{id}', function(int $id){
    
    $candidato_controller = new CandidatoController();
    $vagas_controller = new VagasController();

    $candidato_dados = $candidato_controller->candidato($id);
    $index_nome = strpos($candidato_dados->nome, ' ');
    $candidato_nome = substr($candidato_dados->nome, 0, $index_nome);

    $vagas = $vagas_controller->vagas();

    return view('vagas', ['candidato_nome' => $candidato_nome, 'vagas' => $vagas]);


});


Route::get('/candidaturas/candidato/{id}', function(int $id){
    
    $candidato_controller = new CandidatoController();
    $vagas_controller = new VagasController();

    $candidato_dados = $candidato_controller->candidato($id);
    $index_nome = strpos($candidato_dados->nome, ' ');
    $candidato_nome = substr($candidato_dados->nome, 0, $index_nome);

    $vagas = $vagas_controller->candidatos_vagas($id);

    return view('candidaturas', ['candidato_nome' => $candidato_nome, 'vagas' => $vagas]);


});

Route::get('/vagas/empresa/{id}', function(int $id){ 
    
    $empresas_controller = new EmpresasController();
    $vagas_controller = new VagasController();

    $empresa_dados = $empresas_controller->empresa($id);
    $index_nome = strpos($empresa_dados->nome, ' ');
    $empresa_nome = substr($empresa_dados->nome, 0, $index_nome);

    $vagas = $vagas_controller->empresa_vagas($id);

    return view('empresa-vagas', ['empresa_nome' => $empresa_nome, 'vagas' => $vagas]);


});

Route::get('/vaga/{vaga_id}/empresa/{empresa_id}/candidatos', function(int $vaga_id, int $empresa_id){

    $empresas_controller = new EmpresasController();
    $empresa_dados = $empresas_controller->empresa($empresa_id);
    
    $index_nome = strpos($empresa_dados->nome, ' ');
    $empresa_nome = substr($empresa_dados->nome, 0, $index_nome);

    $dados = ['empresa' => $empresa_id, 'vaga' => $vaga_id];
    $candidatos = $empresas_controller->vaga_candidatos($dados);

    return view('candidatos', ['empresa_nome' => $empresa_nome, 'candidatos' => $candidatos]);

});

Route::get('/vaga/{vaga_id}/editar', function(int $vaga_id){

    $vagas_controller = new VagasController();
    $vaga = $vagas_controller->vaga($vaga_id);
    return view('editar-vaga', ['vaga' => $vaga]);

});

Route::get('/candidato/{candidato_id}/editar', function(int $candidato_id){

    $candidatos_controller = new CandidatoController();
    $candidato = $candidatos_controller->candidato($candidato_id);
    return view('editar-candidato', ['candidato' => $candidato]);

});

Route::get('/empresa/{empresa_id}/editar', function(int $empresa_id){

    $empresas_controller = new EmpresasController();
    $empresa = $empresas_controller->empresa($empresa_id);
    return view('editar-empresa', ['empresa' => $empresa]);

});

