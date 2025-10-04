<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Cliente.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$clienteModel = new Cliente($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_multiple'])) {
    $ids = $_POST['ids'] ?? [];
    if (!empty($ids)) {
        try {
            $clienteModel->deletarMultiplos($ids);
            $_SESSION['sucesso'] = count($ids) . ' cliente(s) excluído(s) com sucesso!';
        } catch (Exception $e) {
            $_SESSION['erro'] = 'Erro ao excluir clientes: ' . $e->getMessage();
        }
    }
    header('Location: ../../index.php');
    exit;
}

$filtros = [
    'nome' => $_GET['nome'] ?? '',
    'cpf' => $_GET['cpf'] ?? '',
    'email' => $_GET['email'] ?? ''
];

$ordem = $_GET['ordem'] ?? 'nome';
$direcao = $_GET['direcao'] ?? 'ASC';
$por_pagina = $_GET['por_pagina'] ?? 20;
$pagina = $_GET['pagina'] ?? 1;
$offset = ($pagina - 1) * $por_pagina;

$clientes = $clienteModel->listar($filtros, $ordem, $direcao, $por_pagina, $offset);
$total = $clienteModel->contar($filtros);
$total_paginas = ceil($total / $por_pagina);

$titulo = 'Clientes';
include '../layout/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);">
            <div class="card-body py-4">
                <div class="text-center">
                    <h2 class="text-white mb-2 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>Clientes
                    </h2>
                    <p class="text-white mb-3">
                        Gerencie todos os seus clientes cadastrados
                    </p>
                    <a href="create.php" class="btn btn-light btn-lg shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Novo Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($filtros['nome']) ?>" placeholder="Filtrar por nome">
            </div>
            <div class="col-md-3">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($filtros['cpf']) ?>" placeholder="Filtrar por CPF">
            </div>
            <div class="col-md-3">
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="<?= htmlspecialchars($filtros['email']) ?>" placeholder="Filtrar por email">
            </div>
            <div class="col-md-3">
                <label class="form-label">Itens por página</label>
                <select name="por_pagina" class="form-select">
                    <option value="10" <?= $por_pagina == 10 ? 'selected' : '' ?>>10</option>
                    <option value="20" <?= $por_pagina == 20 ? 'selected' : '' ?>>20</option>
                    <option value="50" <?= $por_pagina == 50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= $por_pagina == 100 ? 'selected' : '' ?>>100</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filtrar
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpar
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Total: <?= $total ?> cliente(s)</span>
        <button type="button" class="btn btn-sm btn-danger" id="deleteMultiple" disabled>
            <i class="bi bi-trash"></i> Excluir selecionados
        </button>
    </div>
    <div class="card-body p-0">
        <?php if (empty($clientes)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Nenhum cliente encontrado</p>
            </div>
        <?php else: ?>
            <form method="POST" id="formDeleteMultiple">
                <input type="hidden" name="delete_multiple" value="1">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'nome', 'direcao' => $ordem === 'nome' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Nome <?= $ordem === 'nome' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'cpf', 'direcao' => $ordem === 'cpf' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        CPF <?= $ordem === 'cpf' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'email', 'direcao' => $ordem === 'email' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Email <?= $ordem === 'email' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>Telefone</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="<?= $cliente['id'] ?>" class="form-check-input select-item">
                                    </td>
                                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                    <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                    <td class="table-actions">
                                        <a href="view.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        <?php endif; ?>
    </div>
    
    <?php if ($total_paginas > 1): ?>
        <div class="card-footer">
            <nav>
                <ul class="pagination justify-content-center mb-0">
                    <?php if ($pagina > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>">Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = max(1, $pagina - 2); $i <= min($total_paginas, $pagina + 2); $i++): ?>
                        <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($pagina < $total_paginas): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>">Próxima</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
</div>

<?php include '../layout/footer.php'; ?>