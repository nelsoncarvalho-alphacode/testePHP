<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Seu Perfil</h5>
                        <p class="card-text">Nome: {{ $candidato_dados->nome }}</p>
                        <p class="card-text">Email: {{ $candidato_dados->email }}</p>
                        <p class="card-text">Resumo: {{ $candidato_dados->resumo }}</p>
                        <a href="#" class="btn btn-success" id="vagas">Vagas</a>
                        <a href="#" class="btn btn-primary" id="candidaturas">Minhas Candidaturas</a>
                        <a href="#" class="btn btn-primary" id="editar">Alterar dados</a>
                        <button class="btn btn-danger" id="excluir">Excluir Conta</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>

        const vagasLink = document.getElementById('vagas');
        const candidaturasLink = document.getElementById('candidaturas');
        const editarLink = document.getElementById('editar');
        
        const buttonExcluir = document.getElementById('excluir');

        const userId = localStorage.getItem('@userId');

        vagasLink.href = 'http://localhost:8000/vagas/candidato/' + userId;
        candidaturasLink.href = 'http://localhost:8000/candidaturas/candidato/' + userId;
        editarLink.href = 'http://localhost:8000/candidato/'+ userId +'/editar';

        buttonExcluir.onclick = () => {
            
            axios.delete('http://localhost:8000/candidato/excluir/conta/' + userId)
            .then(function (response) {
                console.log(response);
                localStorage.clear();
                window.location = 'http://localhost:8000/';
                    
            })
            .catch(function (error) {
                console.error(error);
            });

        }

    </script>

</body>   

</html>