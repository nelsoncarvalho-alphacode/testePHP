<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulários de Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <div class="row justify-content-center">
                <div class="col-md-6" id="form-candidato">   

                    <h2>Login para Candidatos</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="candidato-email" aria-describedby="emailHelp" placeholder="Seu e-mail">   

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>   
                            <input type="password" class="form-control" id="candidato-password" placeholder="Sua senha">
                        </div>
                        <button type="button" class="btn btn-success" id="entrar-candidato">Entrar</button>   
                        <button type="button" class="btn btn-primary" id="cadastro-candidato">Criar conta</button>
                    </form>

                    <br>
                    <h4 id="error-candidato"></h4>

                </div>

                <div class="col-md-6" style="display: none" id="form-empresa">   

                    <h2>Login para Empresas</h2>
                    <br>

                    <form>
                        <div class="mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="number" class="form-control" id="empresa-cnpj" placeholder="Seu CNPJ (Apenas números)">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form.label">Senha</label>
                            <input type="password" class="form-control" id="empresa-password" placeholder="Sua senha">
                        </div>

                        <button type="button" class="btn btn-success" id="entrar-empresa">Entrar</button>   
                        <button type="button" class="btn btn-primary" id="cadastro-empresa">Criar conta</button>
                    </form>

                    <br>
                    <h4 id="error-empresa"></h4>
                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>   
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>

            localStorage.clear();

            const btnCandidato = document.getElementById('btn-candidato');
            const btnEmpresa = document.getElementById('btn-empresa');
            
            const formCandidato = document.getElementById('form-candidato');
            const formEmpresa = document.getElementById('form-empresa');
            
            const inputEmail = document.getElementById('candidato-email');
            const inputPassword = document.getElementById('candidato-password');
            const inputCnpj = document.getElementById('empresa-cnpj');
            const inputEmpresaPass = document.getElementById('empresa-password');
            
            const buttonCandidato = document.getElementById('entrar-candidato');
            const buttonEmpresa = document.getElementById('entrar-empresa');
            const buttonCriarConta = document.getElementById('criar-conta');
            const buttonCadastroCandidato = document.getElementById('cadastro-candidato');
            const buttonCadastroEmpresa = document.getElementById('cadastro-empresa');

            const errorCandidato = document.getElementById('error-candidato');
            const errorEmpresa = document.getElementById('error-empresa');
            
            buttonCadastroCandidato.onclick = () => {
                window.location = 'http://localhost:8000/cadastro';
            }

            buttonCadastroEmpresa.onclick = () => {
                window.location = 'http://localhost:8000/cadastro';
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
                if(inputEmail.value == null || inputEmail.value == undefined || inputEmail.value == '')
                    inputEmail.style.borderColor = 'red';
                

                else if(inputPassword.value == null || inputPassword.value == undefined || inputPassword.value == '')
                    inputPassword.style.borderColor = 'red';

                else {

                    axios.post('http://localhost:8000/candidato/login', {
                        email: inputEmail.value,
                        senha: inputPassword.value,
                        headers: {
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })

                    .then(function (response) {
                        console.log(response);
                        
                        if(response.data.message == 'Usuário não encontrado' || response.data.message == 'Credenciais incorretas'){
                            errorCandidato.textContent = response.data.message;
                            errorCandidato.style.color = 'red';
                        }
                        
                        else {
                            localStorage.setItem('@userId', response.data.user_id);
                            window.location = 'http://localhost:8000/candidato/' + response.data.user_id;
                        }

                    })
                    .catch(function (error) {
                        console.error(error);
                    });

                }
                
            }

            buttonEmpresa.onclick = () => {
                if(inputCnpj.value == null || inputCnpj.value == undefined || inputCnpj.value == '')
                    inputCnpj.style.borderColor = 'red';
                

                else if(inputEmpresaPass.value == null || inputEmpresaPass.value == undefined || inputEmpresaPass.value == '')
                    inputEmpresaPass.style.borderColor = 'red';

                else {

                    axios.post('http://localhost:8000/empresa/login', {
                        cnpj: inputCnpj.value,
                        senha: inputEmpresaPass.value,
                        headers: {
                            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(function (response) {
                        console.log(response);
                       
                        if(response.data.message == 'Usuário não encontrado' || response.data.message == 'Credenciais incorretas'){
                            errorEmpresa.textContent = response.data.message;
                            errorEmpresa.style.color = 'red';
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
                
            }


        </script>

    </body>
</html> 