<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulários de Cadastro</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <br>
        <div class="container mt-5">
            
            <div class="row justify-content-center">
                <div class="col-md-6" id="form-candidato">   
                    
                    <h2>Cadastro de Vagas</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" aria-describedby="tituloHelp" placeholder="Título da vaga">   

                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" aria-describedby="descricaoHelp" placeholder="Descrição da vaga">   

                        </div>
                        <div class="mb-3">
                            <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                            <select type="text" class="form-control" id="tipo_contrato" aria-describedby="tipoContratoHelp">
                                <option select>CLT</option>
                                <option>Pessoa Jurídica</option>
                                <option>Freelancer</option>
                            </select> 

                        </div>
                        <br>
                        <center>
                            <button type="button" class="btn btn-success" id="cadastrar">Cadastrar</button>   
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
           const buttonRetornar = document.getElementById('retornar-perfil');
           const buttonCadastrar = document.getElementById('cadastrar');

           const inputTitulo = document.getElementById('titulo');
           const inputDescricao = document.getElementById('descricao');
           const inputContrato = document.getElementById('tipo_contrato');

           const message = document.getElementById('message');

           buttonRetornar.onclick = () => {

                window.location = 'http://localhost:8000/empresa/' + userId;

           }
           
           buttonCadastrar.onclick = () => {

                if(inputTitulo.value == '' || inputDescricao.value == ''){
                    message.textContent = 'Todos os campos são obrigatórios';
                    message.style.color = 'red';
                }

                else {

                    const contratoIndex = inputContrato.options.selectedIndex;

                    axios.post('http://localhost:8000/vaga/cadastro', {
                            titulo: inputTitulo.value,
                            descricao: inputDescricao.value,
                            empresa: userId,
                            ativa: true,
                            tipo_contrato: inputContrato.options[contratoIndex].text
                        })
                        .then(function (response) {
                            console.log(response);
                            
                            if(response.data == 'Vaga cadastrada com sucesso'){
                                message.textContent = response.data;
                                message.style.color = 'green';
                            }

                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                }

            }

        </script>

    </body>
</html> 