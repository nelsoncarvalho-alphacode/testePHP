<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Vaga</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <br>
        <div class="container mt-5">
            
            <div class="row justify-content-center">
                <div class="col-md-6" id="form-candidato">   
                    
                    <h2>Editar Vaga</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" aria-describedby="tituloHelp" placeholder="Título da vaga" value="{{ $vaga->titulo }}">   
                            <input type="text" value="{{ $vaga->id }}" style="display: none" id="vaga-id"/>
                        </div>
                        <div class="mb-3">
                            
                            <label for="ativa" class="form-label">Status</label>
                            <select type="text" class="form-control" id="ativa" aria-describedby="ativaHelp">   
                                @if($vaga->ativa == 1)    
                                    <option selected>Aberta</option>
                                @else 
                                    <option>Aberta</option>
                                @endif
                                @if($vaga->ativa == 0)
                                    <option selected>Pausada</option>
                                @else 
                                    <option>Pausada</option>
                                @endif
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" aria-describedby="descricaoHelp" placeholder="Descrição da vaga" value="{{ $vaga->descricao }}">   

                        </div>
                        <div class="mb-3">
                            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                            <select type="text" class="form-control" id="tipo_contrato" aria-describedby="tipoContratoHelp">
                                <option>CLT</option>
                                <option>Pessao Jurídica</option>
                                <option>Freelancer</option>
                            </select> 

                        </div>
                        <br>
                        <center>
                            <button type="button" class="btn btn-success" id="atualizar">Atualizar dados</button>   
                            <button type="button" class="btn btn-primary" id="retornar-perfil">Retornar ao perfil</button>
                        </center>
                    </form> 

                    <br>
                    <h4 id="message"></h4>

                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>   
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>

           const userId = localStorage.getItem('@userId');
           const vagaId = document.getElementById('vaga-id');

           const buttonRetornar = document.getElementById('retornar-perfil');
           const buttonAtualizar = document.getElementById('atualizar');

           const inputTitulo = document.getElementById('titulo');
           const inputDescricao = document.getElementById('descricao');
           const inputContrato = document.getElementById('tipo_contrato');
           const inputAtiva = document.getElementById('ativa');

           const message = document.getElementById('message');

           buttonRetornar.onclick = () => {

                window.location = 'http://localhost:8000/empresa/' + userId;

           }
           
           buttonAtualizar.onclick = () => {

             
                const contratoIndex = inputContrato.options.selectedIndex;
                const ativaIndex = inputAtiva.options.selectedIndex;
                var ativa = inputAtiva.options[ativaIndex].text;

                if(ativa == 'Aberta')
                    ativa = 1;
                if(ativa == 'Pausada')  
                    ativa = 0;

                axios.put('http://localhost:8000/vaga/editar', {
                    id: vagaId.value,
                    novo_titulo: inputTitulo.value,
                    nova_descricao: inputDescricao.value,
                    ativa: ativa,
                    novo_tipo_contrato: inputContrato.options[contratoIndex].text
                })
                .then(function (response) {
                    console.log(response);
                    message.textContent = response.data.message;
                    message.style.color = 'green';

                })
                .catch(function (error) {
                    console.error(error);
                });
            

        }

        </script>

    </body>
</html> 