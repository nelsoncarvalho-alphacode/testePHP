<?php
// View de edição de perfil - permite ao usuário editar seus próprios dados
require_once __DIR__ . '/../../bootstrap.php';
use Repository\UserRepository;

// Verifica autenticação do usuário
session_start();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: /login');
    exit;
}

// Busca dados do usuário logado
$user = null;
if ($userId) {
    $repo = new UserRepository();
    $user = $repo->find($userId);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="/produtos" class="btn btn-secondary btn-sm me-2">Voltar para Produtos</a>
                            <a href="/meu-perfil" class="btn btn-outline-primary btn-sm">Ver Perfil Completo</a>
                        </div>
                        <form id="profileForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cpf" name="cpf" 
                                       value="<?= htmlspecialchars($user['cpf'] ?? '') ?>" 
                                       placeholder="000.000.000-00" maxlength="14" required>
                                <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
                            </div>
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço</label>
                                <textarea class="form-control" id="endereco" name="endereco" rows="3" 
                                          placeholder="Rua, número, bairro, cidade"><?= htmlspecialchars($user['endereco'] ?? '') ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                        </form>
                        <div id="result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para aplicar máscara de CPF
        function maskCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
            cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            return cpf;
        }

        // Função para validar CPF
        function validateCPF(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11) return false;
            if (/^(\d)\1{10}$/.test(cpf)) return false;
            
            let sum = 0;
            for (let i = 0; i < 9; i++) {
                sum += parseInt(cpf.charAt(i)) * (10 - i);
            }
            let remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            if (remainder !== parseInt(cpf.charAt(9))) return false;
            
            sum = 0;
            for (let i = 0; i < 10; i++) {
                sum += parseInt(cpf.charAt(i)) * (11 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) remainder = 0;
            return remainder === parseInt(cpf.charAt(10));
        }

        // Aplicar máscara ao digitar no campo existente
        document.getElementById('cpf').addEventListener('input', function(e) {
            e.target.value = maskCPF(e.target.value);
        });

        // Aplicar máscara ao valor já carregado
        window.addEventListener('load', function() {
            const cpfField = document.getElementById('cpf');
            if (cpfField.value) {
                cpfField.value = maskCPF(cpfField.value);
            }
        });

        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Validar CPF
            if (!validateCPF(data.cpf)) {
                document.getElementById('cpf').classList.add('is-invalid');
                document.getElementById('cpf').focus();
                return;
            } else {
                document.getElementById('cpf').classList.remove('is-invalid');
            }
            
            // Remove password se estiver vazio
            if (!data.password || data.password.trim() === '') {
                delete data.password;
            }
            
            fetch(`/api/users/<?= $userId ?>`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Error response:', text);
                        throw new Error(`Erro ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                const resultDiv = document.getElementById('result');
                if (data.error) {
                    resultDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                } else {
                    resultDiv.innerHTML = `<div class="alert alert-success">${data.message || 'Perfil atualizado com sucesso!'}</div>`;
                    // Limpa o campo de senha
                    document.getElementById('password').value = '';
                    // Recarrega os dados do usuário
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Erro completo:', error);
                document.getElementById('result').innerHTML = `<div class="alert alert-danger">Erro ao atualizar perfil: ${error.message}</div>`;
            });
        });
    </script>
</body>
</html>