<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$pedidoModel = new Pedido($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_multiple'])) {
    $ids = $_POST['ids'] ?? [];
    if (!empty($ids)) {
        try {
            $pedidoModel->deletarMultiplos($ids);
            $_SESSION['sucesso'] = count($ids) . ' pedido(s) excluído(s) com sucesso!';
        } catch (Exception $e) {
            $_SESSION['erro'] = 'Erro ao excluir pedidos: ' . $e->getMessage();
        }
    }
    header('Location: index.php');
    exit;
}

// Filtros e ordenação
$filtros = [
    'numero_pedido' => $_GET['numero_pedido'] ?? '',
    'cliente_nome' => $_GET['cliente_nome'] ?? '',
    'status' => $_GET['status'] ?? '',
    'data_inicio' => $_GET['data_inicio'] ?? '',
    'data_fim' => $_GET['data_fim'] ?? ''
];

$ordem = $_GET['ordem'] ?? 'data_pedido';
$direcao = $_GET['direcao'] ?? 'DESC';
$por_pagina = $_GET['por_pagina'] ?? 20;
$pagina = $_GET['pagina'] ?? 1;
$offset = ($pagina - 1) * $por_pagina;

$pedidos = $pedidoModel->listar($filtros, $ordem, $direcao, $por_pagina, $offset);
$total = $pedidoModel->contar($filtros);
$total_paginas = ceil($total / $por_pagina);

$titulo = 'Pedidos';
include '../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart"></i> Pedidos</h2>
    <a href="create.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Pedido
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-2">
                <label class="form-label">Número</label>
                <input type="text" name="numero_pedido" class="form-control" value="<?= htmlspecialchars($filtros['numero_pedido']) ?>" placeholder="PED-2025-001">
            </div>
            <div class="col-md-3">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente_nome" class="form-control" value="<?= htmlspecialchars($filtros['cliente_nome']) ?>" placeholder="Nome do cliente">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="Em Aberto" <?= $filtros['status'] === 'Em Aberto' ? 'selected' : '' ?>>Em Aberto</option>
                    <option value="Pago" <?= $filtros['status'] === 'Pago' ? 'selected' : '' ?>>Pago</option>
                    <option value="Cancelado" <?= $filtros['status'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Data Início</label>
                <input type="date" name="data_inicio" class="form-control" value="<?= htmlspecialchars($filtros['data_inicio']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Data Fim</label>
                <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtros['data_fim']) ?>">
            </div>
            <div class="col-md-1">
                <label class="form-label">Por pág.</label>
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
        <span>Total: <?= $total ?> pedido(s)</span>
        <button type="button" class="btn btn-sm btn-danger" id="deleteMultiple">
            <i class="bi bi-trash"></i> Excluir selecionados
        </button>
    </div>
    <div class="card-body p-0">
        <?php if (empty($pedidos)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Nenhum pedido encontrado</p>
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
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'numero_pedido', 'direcao' => $ordem === 'numero_pedido' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Número <?= $ordem === 'numero_pedido' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'cliente_nome', 'direcao' => $ordem === 'cliente_nome' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Cliente <?= $ordem === 'cliente_nome' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'data_pedido', 'direcao' => $ordem === 'data_pedido' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Data <?= $ordem === 'data_pedido' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>Status</th>
                                <th>Desconto</th>
                                <th>Valor Total</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="<?= $pedido['id'] ?>" class="form-check-input select-item">
                                    </td>
                                    <td><?= htmlspecialchars($pedido['numero_pedido']) ?></td>
                                    <td>
                                        <a href="../clientes/view.php?id=<?= $pedido['cliente_id'] ?>">
                                            <?= htmlspecialchars($pedido['cliente_nome']) ?>
                                        </a>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                                    <td>
                                        <?php
                                        $badge_class = [
                                            'Em Aberto' => 'bg-warning text-dark',
                                            'Pago' => 'bg-success',
                                            'Cancelado' => 'bg-danger'
                                        ];
                                        ?>
                                        <span class="badge <?= $badge_class[$pedido['status']] ?>">
                                            <?= htmlspecialchars($pedido['status']) ?>
                                        </span>
                                    </td>
                                    <td>R$ <?= number_format($pedido['desconto'], 2, ',', '.') ?></td>
                                    <td><strong>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></strong></td>
                                    <td class="table-actions">
                                        <a href="view.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Excluir">
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