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
                        <p class="card-text">Nome: {{ $empresa_dados->nome }}</p>
                        <p class="card-text">E-mail: {{ $empresa_dados->email }}</p>
                        <p class="card-text">CNPJ: {{ $empresa_dados->cnpj }}</p>
                        <p class="card-text">Descrição: {{ $empresa_dados->descricao }}</p>
                        <a href="#" class="btn btn-success" id="vagas">Minhas Vagas</a>
                        <a href="http://localhost:8000/cadastro/vaga" class="btn btn-primary" id="criar-vaga">Criar Vaga</a>
                        <button class="btn btn-danger" id="excluir">Excluir conta</button>
                        <a href="#" class="btn btn-secondary" id="atualizar">Alterar dados</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        
        const userId = localStorage.getItem('@userId');

        const vagasLink = document.getElementById('vagas');
        
        const buttonExcluir = document.getElementById('excluir');
        const atualizarLink = document.getElementById('atualizar');

        vagasLink.href = 'http://localhost:8000/vagas/empresa/' + userId;
        atualizarLink.href = 'http://localhost:8000/empresa/'+ userId +'/editar';
        
        buttonExcluir.onclick = () => {

            axios.delete('http://localhost:8000/empresa/excluir/conta/' + userId)
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