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
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Usuários Cadastrados</h4>
                    </div>
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
        function listUsers() {
            fetch('http://orders-app.test/app/usuarios')
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
                                    <button class="btn btn-warning btn-sm me-2" onclick="editUser(${user.id})">Editar</button>
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
                    fetch(`http://orders-app.test/app/usuarios/${id}`, {
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