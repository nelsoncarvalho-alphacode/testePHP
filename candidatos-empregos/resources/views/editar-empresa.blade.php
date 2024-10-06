<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alterar seus dados</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <br>
        <div class="container mt-5">
            
            <div class="row justify-content-center">
                <div class="col-md-6" id="form-candidato">   
                    
                    <h2>Alterar Dados</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" aria-describedby="tituloHelp" placeholder="Seu nome" value="{{ $empresa->nome }}">   
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu e-mail" value="{{ $empresa->email }}">   
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" class="form-control" id="descricao" aria-describedby="descricaoHelp" placeholder="Descrição da sua empresa" value="{{ $empresa->descricao }}">   
                        </div>
                        <div class="mb-3">
                            <label for="cnpj" class="form-label">Seu CNPJ</label>
                            <input type="number" class="form-control" id="cnpj" aria-describedby="cnpjHelp" placeholder="Seu CNPJ numérico" value="{{ $empresa->cnpj }}">   
                        </div>
                        <br>
                        <center>
                            <button type="button" class="btn btn-success" id="atualizar">Atualizar dados</button>   
                            <a href="#" class="btn btn-primary" id="retornar-perfil">Retornar ao perfil</a>
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

           const retornarLink = document.getElementById('retornar-perfil');
           const buttonAtualizar = document.getElementById('atualizar');

           const inputNome = document.getElementById('nome');
           const inputEmail = document.getElementById('email');
           const inputDescricao = document.getElementById('descricao');
           const inputCnpj = document.getElementById('cnpj');

           const message = document.getElementById('message');

           retornarLink.href = 'http://localhost:8000/empresa/' + userId;
           
           buttonAtualizar.onclick = () => {

                axios.put('http://localhost:8000/empresa/editar', {
                    id: userId,
                    novo_nome: inputNome.value,
                    novo_email: inputEmail.value,
                    nova_descricao: inputDescricao.value,
                    novo_cnpj: inputCnpj.value
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