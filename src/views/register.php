<?php
session_start();
require_once '../config/db.php';
require_once '../models/Usuario.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        $erro = 'Preencha todos os campos.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'As senhas não coincidem.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        $usuarioModel = new Usuario($pdo);
        
        if ($usuarioModel->buscarPorEmail($email)) {
            $erro = 'Este email já está cadastrado.';
        } else {
            if ($usuarioModel->criar($nome, $email, $senha)) {
                $_SESSION['sucesso'] = 'Cadastro realizado com sucesso!';
                header('Location: login.php');
                exit;
            } else {
                $erro = 'Erro ao criar usuário. Tente novamente.';
            }
        }
    }
}

$titulo = 'Cadastro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #0047AB, #007BFF, #FFD700);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #0047AB, #007BFF, #FFD700);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s;
        }
        .strength-weak { background-color: #dc3545; width: 33%; }
        .strength-medium { background-color: #ffc107; width: 66%; }
        .strength-strong { background-color: #28a745; width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card register-card">
                    <div class="card-header text-center py-4">
                        <h3 class="mb-0"><i class="bi bi-person-plus"></i> Criar Conta</h3>
                        <p class="mb-0 mt-2 small">Pedify</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($erro) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" id="formRegister">
                            <div class="mb-3">
                                <label class="form-label">Nome completo <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nome" class="form-control" required 
                                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                                           placeholder="Digite seu nome completo">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" required 
                                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                           placeholder="seu@email.com">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Senha <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="senha" id="senha" class="form-control" required
                                           placeholder="Mínimo 6 caracteres">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleSenha">
                                        <i class="bi bi-eye" id="iconSenha"></i>
                                    </button>
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                                <small class="text-muted" id="strengthText"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar senha <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control" required
                                           placeholder="Digite a senha novamente">
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmar">
                                        <i class="bi bi-eye" id="iconConfirmar"></i>
                                    </button>
                                </div>
                                <small class="text-muted" id="matchText"></small>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="termos" required>
                                <label class="form-check-label" for="termos">
                                    Concordo com os <a href="#" data-bs-toggle="modal" data-bs-target="#modalTermos">termos de uso</a>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-check-circle"></i> Cadastrar
                            </button>
                        </form>

                        <hr>
                        <p class="text-center mb-0">
                            Já tem conta? <a href="login.php">Faça login aqui</a>
                        </p>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-white">
                        <i class="bi bi-shield-check"></i> Seus dados estão seguros conosco
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Termos de Uso -->
    <div class="modal fade" id="modalTermos" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-file-text"></i> Termos de Uso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Aceitação dos Termos</h6>
                    <p>Ao utilizar este sistema, você concorda com os termos e condições aqui estabelecidos.</p>

                    <h6>2. Uso do Sistema</h6>
                    <p>Este sistema é destinado ao gerenciamento de pedidos e deve ser utilizado de forma responsável.</p>

                    <h6>3. Privacidade</h6>
                    <p>Seus dados pessoais serão tratados de acordo com a LGPD e mantidos em segurança.</p>

                    <h6>4. Responsabilidades</h6>
                    <p>O usuário é responsável por manter suas credenciais de acesso em sigilo.</p>

                    <h6>5. Alterações</h6>
                    <p>Reservamo-nos o direito de modificar estes termos a qualquer momento.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle mostrar/ocultar senha
        document.getElementById('toggleSenha').addEventListener('click', function() {
            const senhaInput = document.getElementById('senha');
            const icon = document.getElementById('iconSenha');
            
            if (senhaInput.type === 'password') {
                senhaInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                senhaInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleConfirmar').addEventListener('click', function() {
            const confirmarInput = document.getElementById('confirmar_senha');
            const icon = document.getElementById('iconConfirmar');
            
            if (confirmarInput.type === 'password') {
                confirmarInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                confirmarInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });

        // Verificar força da senha
        document.getElementById('senha').addEventListener('input', function() {
            const senha = this.value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            let text = '';
            
            if (senha.length >= 6) strength++;
            if (senha.length >= 10) strength++;
            if (/[a-z]/.test(senha) && /[A-Z]/.test(senha)) strength++;
            if (/\d/.test(senha)) strength++;
            if (/[^a-zA-Z\d]/.test(senha)) strength++;
            
            strengthBar.className = 'password-strength';
            
            if (senha.length === 0) {
                strengthBar.style.width = '0';
                text = '';
            } else if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
                text = 'Senha fraca';
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-medium');
                text = 'Senha média';
            } else {
                strengthBar.classList.add('strength-strong');
                text = 'Senha forte';
            }
            
            strengthText.textContent = text;
        });

        // Verificar se senhas coincidem
        document.getElementById('confirmar_senha').addEventListener('input', function() {
            const senha = document.getElementById('senha').value;
            const confirmar = this.value;
            const matchText = document.getElementById('matchText');
            
            if (confirmar.length === 0) {
                matchText.textContent = '';
                matchText.className = 'text-muted';
            } else if (senha === confirmar) {
                matchText.textContent = '✓ As senhas coincidem';
                matchText.className = 'text-success';
            } else {
                matchText.textContent = '✗ As senhas não coincidem';
                matchText.className = 'text-danger';
            }
        });

        // Validação do formulário
        document.getElementById('formRegister').addEventListener('submit', function(e) {
            const senha = document.getElementById('senha').value;
            const confirmar = document.getElementById('confirmar_senha').value;
            
            if (senha !== confirmar) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                return false;
            }
            
            if (senha.length < 6) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres!');
                return false;
            }
        });
    </script>
</body>
</html>