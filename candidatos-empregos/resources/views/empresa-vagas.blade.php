<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vagas</title>
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
                <h2 class="text-center">Minhas Vagas</h2>
                <br>

                @foreach($vagas as $vaga)

                    <div class="row justify-content-center" id="vaga-{{ $vaga->id }}">
                        <div class="col-md-4 mb-4" style="width: 1000px;">
                            <div class="card">
                                <div class="card-body">
                                    <input value="{{ $vaga->id }}" style="display: none" id="vaga-id" />
                                    <h5 class="card-title">{{ $vaga->titulo }}</h5>
                                    <br>
                                    <h6>Descrição da vaga</h6>
                                    <p class="card-text">{{ $vaga->descricao }}</p>
                                    
                                    <h6>Status</h6>

                                    @if($vaga->ativa != 0)
                                        <p class="card-text" style="color: green">Aberta</p>
                                    @else 
                                        <p class="card-text" style="color: red">Fechada</p>
                                    @endif

                                    <h6>Tipo de contrato</h6>
                                    <p class="card-text">{{ $vaga->tipo_contrato }}</p>

                                    <button class="btn btn-primary" onclick="editar({{ $vaga->id }})" id="btn-{{ $vaga->id }}">Editar</button>
                                    <button class="btn btn-danger" onclick="excluir({{ $vaga->id }})" id="btn-{{ $vaga->id }}">Excluir</button>
                                    <button class="btn btn-success" onclick="candidatos({{ $vaga->id }})" id="btn-{{ $vaga->id }}">Ver candidatos</button>
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
        
        function excluir(vagaId) {

            const vaga = document.getElementById('vaga-' + vagaId);

            axios.delete('http://localhost:8000/vaga/excluir/' + vagaId)
            .then(function (response) {
                console.log(response);
                vaga.parentNode.removeChild(vaga);

            })
            .catch(function (error) {
                console.error(error);
            });
        }

        function candidatos(vagaId){
            window.location ='http://localhost:8000/vaga/'+ vagaId +'/empresa/'+ userId +'/candidatos';
        }

        function editar(vagaId){
            window.location = 'http://localhost:8000/vaga/' + vagaId + '/editar';
        }

    </script>

</body>
</html>