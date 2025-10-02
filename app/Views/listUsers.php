<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Usuários Cadastrados</h4>
                            <div>
                                <a href="/app/admin-cadastro" class="btn btn-success btn-sm me-2">Cadastrar Usuário</a>
                                <a id="adminPanelBtn" href="#" class="btn btn-dark btn-sm" style="display:none;">Voltar para Painel Admin</a>
                            </div>
                    </div>
                                        <div id="headerButtons"></div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th style="width: 160px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="userTable"></tbody>
                        </table>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        fetch('/app/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                    if (isAdmin) {
                        document.getElementById('adminPanelBtn').style.display = '';
                        document.getElementById('adminPanelBtn').setAttribute('href', '/app/admin');
                    }
            })
            .catch(() => {
                    document.getElementById('adminPanelBtn').style.display = 'none';
            });

        function renderHeaderButtons() {
            const headerDiv = document.getElementById('headerButtons');
            let html = '';
            if (isAdmin) {
                html += '<a href="/app/admin" class="btn btn-dark btn-sm me-2">Voltar para Painel Admin</a>';
            }
            html += '<a href="#" onclick="logout()" class="btn btn-outline-light btn-sm">Logout</a>';
            headerDiv.innerHTML = html;
        }
        let isAdmin = false;
        // Busca se o usuário é admin
        fetch('/app/api/session')
            .then(response => response.json())
            .then(data => {
                isAdmin = !!data.is_admin;
                if (isAdmin) {
                    listUsers();
                } else {
                    document.body.innerHTML = '<div class="container mt-5"><div class="alert alert-danger">Acesso restrito: apenas administradores podem visualizar esta página.</div></div>';
                }
            })
            .catch(() => {
                document.body.innerHTML = '<div class="container mt-5"><div class="alert alert-danger">Erro ao verificar permissão.</div></div>';
            });

        function listUsers() {
            fetch('http://orders-app.test/app/api/users')
            .then(response => response.json())
            .then(users => {
                const tbody = document.getElementById('userTable');
                tbody.innerHTML = '';
                if (Array.isArray(users) && users.length > 0) {
                    users.forEach(user => {
                        tbody.innerHTML += `<tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm me-2" onclick="window.location.href='/app/editar-informacoes/${user.id}'">Editar</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.id})">Excluir</button>
                                </td>
                        </tr>`;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="2">Nenhum usuário encontrado.</td></tr>';
                }
            })
            .catch(() => {
                document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao listar usuários.</div>`;
            });
        }

            function editUser(id) {
                alert('Função de editar usuário ' + id + ' ainda não implementada.');
            }

            function deleteUser(id) {
                if (confirm('Tem certeza que deseja excluir o usuário?')) {
                    fetch(`http://orders-app.test/app/api/users/${id}`, {
                        method: 'DELETE'
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message || data.error);
                        listUsers();
                    })
                    .catch(() => {
                        alert('Erro ao excluir usuário.');
                    });
                }
            }

        // Carregar lista ao abrir
        listUsers();
    </script>
</body>
</html>