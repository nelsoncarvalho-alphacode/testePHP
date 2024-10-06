<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            
            <div class="col-md-3" style="display: flex; position: absolute; left: 0">   
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $empresa_nome }}</h5>
                        <a class="card-text" id="retornar-perfil">Ver Perfil</a>
                    </div>
                </div>
            </div>

        
            <div class="col-md-9">
                <h2 class="text-center">Candidatos da Vaga</h2> 
                <br>

                @foreach($candidatos as $candidato)

                    <div class="row justify-content-center" id="vaga-{{ $candidato->id }}">
                        <div class="col-md-4 mb-4" style="width: 1000px;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $candidato->nome }}</h5>
                                    <br>
                                    <h6>E-mail</h6>
                                    <p class="card-text">{{ $candidato->email }}</p>
                                    <h6>Resumo</h6>
                                    <p class="card-text">{{ $candidato->resumo }}</p>
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
        
        retornarLink.href = 'http://localhost:8000/empresa/' + userId;
        
        
    </script>

</body>
</html>