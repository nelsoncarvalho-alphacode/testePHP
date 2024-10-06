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
                            <input type="text" class="form-control" id="nome" aria-describedby="tituloHelp" placeholder="Seu nome" value="{{ $candidato->nome }}">   
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Seu e-mail" value="{{ $candidato->email }}">   
                        </div>
                        <div class="mb-3">
                            <label for="resumo" class="form-label">Resumo</label>
                            <input type="text" class="form-control" id="resumo" aria-describedby="resumoHelp" placeholder="Resumo do seu perfil profissional" value="{{ $candidato->resumo }}">   
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

           const buttonRetornar = document.getElementById('retornar-perfil');
           const buttonAtualizar = document.getElementById('atualizar');

           const inputNome = document.getElementById('nome');
           const inputEmail = document.getElementById('email');
           const inputResumo = document.getElementById('resumo');

           const message = document.getElementById('message');

           buttonRetornar.onclick = () => {
                window.location = 'http://localhost:8000/candidato/' + userId;
           }
           
           buttonAtualizar.onclick = () => {

                axios.put('http://localhost:8000/candidato/editar', {
                    id: userId,
                    novo_nome: inputNome.value,
                    novo_email: inputEmail.value,
                    novo_resumo: inputResumo.value
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