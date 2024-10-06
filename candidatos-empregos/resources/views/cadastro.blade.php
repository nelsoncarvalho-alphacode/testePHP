<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulários de Cadastro</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <div class="container mt-5">
            <center>
                <div class="row">
                    <div class="col-md-12">
                            <button class="btn btn-primary" id="btn-candidato">Candidato</button>
                            <button class="btn btn-primary" id="btn-empresa">Empresa</button>
                    </div>
                </div>
            </center>

            <br>

            <div class="row justify-content-center">
                <div class="col-md-6" id="form-candidato">   

                    <h2>Cadastro de Candidatos</h2>
                        
                    <form>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="candidato-nome" aria-describedby="nomeHelp" placeholder="Seu nome">   

                        </div>
                        <div class="mb-3">
                            <label for="candidato-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="candidato-email" aria-describedby="emailHelp" placeholder="Seu e-mail">   

                        </div>
                        <div class="mb-3">
                            <label for="candidato-resumo" class="form-label">Resumo</label>
                            <input type="text" class="form-control" id="candidato-resumo" aria-describedby="resumoHelp" placeholder="Resumo do seu perfil profissional">   

                        </div>
                        <div class="mb-3">
                            <label for="candidato-password" class="form-label">Senha</label>   
                            <input type="password" class="form-control" id="candidato-password" placeholder="Sua senha">
                        </div>
                        <br>
                        <center>
                            <button type="button" class="btn btn-success" id="cadastrar-candidato">Cadastrar</button>   
                            <button type="button" class="btn btn-primary" id="retornar-login-candidato">Já possuo conta</button>
                        </center>
                    </form>

                </div>
                

                <div class="col-md-6" style="display: none" id="form-empresa"> 

                    <h2>Cadastro de Empresas</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="number" class="form-control required" id="empresa-cnpj" placeholder="Seu CNPJ (Apenas números)">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form.label">Senha</label>
                            <input type="password" class="form-control required" id="empresa-password" placeholder="Sua senha">
                        </div>
                        <div class="mb-3">
                            <label for="empresa-descricao" class="form.label">Descrição da sua empresa</label>
                            <input type="text" class="form-control required" id="empresa-descricao" placeholder="Breve descrição da sua empresa">
                        </div>
                        <br>
                        <center>
                            <button type="button" class="btn btn-success" id="cadastrar-empresa">Cadastrar</button>   
                            <button type="button" class="btn btn-primary" id="retornar-login-empresa">Já possuo conta</button>
                        </center>
                    </form>

                </div>
            </div>
            
            <br>
            <h4 id="error"></h4>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>   
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>

            localStorage.clear();

            const btnCandidato = document.getElementById('btn-candidato');
            const btnEmpresa = document.getElementById('btn-empresa');
            
            const formCandidato = document.getElementById('form-candidato');
            const formEmpresa = document.getElementById('form-empresa');
            
            const inputNome = document.getElementById('candidato-nome');
            const inputEmail = document.getElementById('candidato-email');
            const inputResumo = document.getElementById('candidato-resumo');
            const inputPassword = document.getElementById('candidato-password');

            const inputCnpj = document.getElementById('empresa-cnpj');
            const inputEmpresaPass = document.getElementById('empresa-password');
            const inputDescricao = document.getElementById('empresa-descricao');

            const buttonCandidato = document.getElementById('cadastrar-candidato');
            const buttonEmpresa = document.getElementById('cadastrar-empresa');
            const buttonLoginCandidato = document.getElementById('retornar-login-candidato');
            const buttonLoginEmpresa = document.getElementById('retornar-login-empresa');

            const error = document.getElementById('error');
            
            buttonLoginCandidato.onclick = () => {
                window.location = 'http://localhost:8000';
            }

            buttonLoginEmpresa.onclick = () => {
                window.location = 'http://localhost:8000';
            }

            btnCandidato.onclick = () => {
                formEmpresa.style.display = 'none';
                formCandidato.style.display = 'block';
            }

            btnEmpresa.onclick = () => {
                formCandidato.style.display = 'none';
                formEmpresa.style.display = 'block';
            }

            buttonCandidato.onclick = () => {
                

                axios.post('http://localhost:8000/candidato/cadastro', {
                    nome: inputNome.value,
                    email: inputEmail.value,
                    resumo: inputResumo.value,
                    senha: inputPassword.value
                })
                .then(function (response) {
                    console.log(response);
                    localStorage.setItem('@userId', response.data.user_id);
                    window.location = 'http://localhost:8000/candidato/' + response.data.user_id;

                })
                .catch(function (error) {
                    console.error(error);
                });
                
                
            }

            buttonEmpresa.onclick = () => {
            
                axios.post('http://localhost:8000/empresa/cadastro', {
                    cnpj: inputCnpj.value,
                    senha: inputEmpresaPass.value,
                    descricao: inputDescricao.value
                })
                .then(function (response) {
                        
                    console.log(response);
                        
                    if(response.data.message == 'CNPJ inválido') {
                        error.textContent = response.data.message;
                        error.style.color = 'red';
                    }

                    else {
                        localStorage.setItem('@userId', response.data.user_id);
                        localStorage.setItem('@message', response.data.message);
                        window.location = 'http://localhost:8000/empresa/' + response.data.user_id;
                    }


                })

                .catch(function (error) {
                    console.error(error);
                });

                
                
            }
            

        </script>

    </body>
</html> 