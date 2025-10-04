<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se está logado
$pagina_atual = basename($_SERVER['PHP_SELF']);
$caminho_completo = $_SERVER['PHP_SELF'];
$paginas_publicas = ['views/login.php', 'views/register.php'];

if (!isset($_SESSION['usuario_id']) && !in_array($pagina_atual, $paginas_publicas)) {
    header('Location: views/login.php');
    exit;
}

$root_path = '';
if (strpos($_SERVER['PHP_SELF'], '/views/') !== false) {
    $root_path = '../../';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Pedify' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #0dcaf0;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }

        main {
            flex: 1;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
        }

        .navbar-brand i {
            color: #ffc107;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.3s;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
        }

        .table-actions {
            white-space: nowrap;
        }

        .table-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .status-badge {
            font-size: 0.875rem;
            padding: 0.35em 0.65em;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .page-link {
            color: var(--primary-color);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: "›";
        }

        .alert {
            border: none;
            border-left: 4px solid;
        }

        .alert-success {
            border-left-color: var(--success-color);
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .alert-danger {
            border-left-color: var(--danger-color);
            background-color: #f8d7da;
            color: #842029;
        }

        .alert-warning {
            border-left-color: var(--warning-color);
            background-color: #fff3cd;
            color: #664d03;
        }

        .alert-info {
            border-left-color: var(--info-color);
            background-color: #cff4fc;
            color: #055160;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .input-group-text {
            background-color: #e9ecef;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        .input-group .form-control:focus {
            border-color: #ced4da;
            box-shadow: none;
        }

        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
            border: none;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }

            .card-body {
                padding: 1rem;
            }
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-overlay.show {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $root_path ?>index.php">
                <i class="bi bi-cart-check"></i> Pedify
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= ($pagina_atual === 'index.php' && strpos($caminho_completo, '/views/') === false) ? 'active' : '' ?>" 
                           href="<?= $root_path ?>index.php">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($caminho_completo, '/clientes/') !== false ? 'active' : '' ?>" 
                           href="<?= $root_path ?>views/clientes/index.php">
                            <i class="bi bi-people"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($caminho_completo, '/produtos/') !== false ? 'active' : '' ?>" 
                           href="<?= $root_path ?>views/produtos/index.php">
                            <i class="bi bi-box-seam"></i> Produtos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($caminho_completo, '/pedidos/') !== false ? 'active' : '' ?>" 
                           href="<?= $root_path ?>views/pedidos/index.php">
                            <i class="bi bi-cart"></i> Pedidos
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item text-danger" href="<?= $root_path ?>logout.php">
                                    <i class="bi bi-box-arrow-right"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="border-bottom border-warning border-4"></div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="py-4 fade-in">
        <div class="container-fluid">
            <?php
            if (isset($_SESSION['sucesso'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                echo '<i class="bi bi-check-circle-fill"></i> ' . htmlspecialchars($_SESSION['sucesso']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                echo '</div>';
                unset($_SESSION['sucesso']);
            }
            
            // Exibir mensagens de erro
            if (isset($_SESSION['erro'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                echo '<i class="bi bi-exclamation-triangle-fill"></i> ' . htmlspecialchars($_SESSION['erro']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                echo '</div>';
                unset($_SESSION['erro']);
            }

            // Exibir mensagens de aviso
            if (isset($_SESSION['aviso'])) {
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
                echo '<i class="bi bi-exclamation-circle-fill"></i> ' . htmlspecialchars($_SESSION['aviso']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                echo '</div>';
                unset($_SESSION['aviso']);
            }

            // Exibir mensagens de informação
            if (isset($_SESSION['info'])) {
                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                echo '<i class="bi bi-info-circle-fill"></i> ' . htmlspecialchars($_SESSION['info']);
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                echo '</div>';
                unset($_SESSION['info']);
            }
            ?>

            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Carregando...</span>
                </div>
            </div>