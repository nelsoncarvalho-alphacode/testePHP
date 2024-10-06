<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas Abertas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            
            <div class="col-md-3" style="display: flex; position: absolute; left: 0">   
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $candidato_nome }}</h5>
                        <a class="card-text" id="retornar-perfil">Ver Perfil</a>
                    </div>
                </div>
            </div>

        
            <div class="col-md-9">
                <h2 class="text-center">Vagas Abertas</h2>
                <br>

                @foreach($vagas as $vaga)

                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-4" style="width: 1000px;">
                            <div class="card">
                                <div class="card-body">
                                    <input value="{{ $vaga->id }}" style="display: none" id="vaga-id" />
                                    <h5 class="card-title">{{ $vaga->titulo }}</h5>
                                    <br>
                                    <h6>Descrição da vaga</h6>
                                    <p class="card-text">{{ $vaga->descricao }}</p>
                                    <h6>Empresa</h6>
                                    <p class="card-text">{{ $vaga->empresa }}</p>
                                    <h6>Tipo de contrato</h6>
                                    <p class="card-text">{{ $vaga->tipo_contrato }}</p>
                                    <button class="btn btn-primary" onclick="candidatar({{ $vaga->id }})" id="btn-{{ $vaga->id }}">Candidatar-se</button>
                                    <h6 id="message-{{ $vaga->id }}" style="display: none">Candidatura enviada</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>   
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>

        const retornarLink = document.getElementById('retornar-perfil');
        const userId = localStorage.getItem('@userId');
        
        retornarLink.href = 'http://localhost:8000/candidato/' + userId;
        
        function candidatar(vagaId) {

            const button = document.getElementById('btn-' + vagaId);
            const message = document.getElementById('message-' + vagaId);

            axios.post('http://localhost:8000/vaga/candidatar', {
                    candidato: userId,
                    vaga: vagaId,
                })
                .then(function (response) {
                    console.log(response);
                    button.style.display = 'none';
                    message.style.display = 'block';
                    message.style.color = 'green';

                })
                .catch(function (error) {
                    console.error(error);
                });
        }

    </script>

</body>
</html>