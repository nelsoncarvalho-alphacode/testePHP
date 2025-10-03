<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$produtoModel = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_multiple'])) {
    $ids = $_POST['ids'] ?? [];
    if (!empty($ids)) {
        try {
            $produtoModel->deletarMultiplos($ids);
            $_SESSION['sucesso'] = count($ids) . ' produto(s) excluído(s) com sucesso!';
        } catch (Exception $e) {
            $_SESSION['erro'] = 'Erro ao excluir produtos: ' . $e->getMessage();
        }
    }
    header('Location: index.php');
    exit;
}

// Filtros e ordenação
$filtros = [
    'nome' => $_GET['nome'] ?? '',
    'cod_barras' => $_GET['cod_barras'] ?? '',
    'preco_min' => $_GET['preco_min'] ?? '',
    'preco_max' => $_GET['preco_max'] ?? ''
];

$ordem = $_GET['ordem'] ?? 'nome';
$direcao = $_GET['direcao'] ?? 'ASC';
$por_pagina = $_GET['por_pagina'] ?? 20;
$pagina = $_GET['pagina'] ?? 1;
$offset = ($pagina - 1) * $por_pagina;

$produtos = $produtoModel->listar($filtros, $ordem, $direcao, $por_pagina, $offset);
$total = $produtoModel->contar($filtros);
$total_paginas = ceil($total / $por_pagina);

$titulo = 'Produtos';
include '../layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Produtos</h2>
    <a href="create.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Produto
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($filtros['nome']) ?>" placeholder="Filtrar por nome">
            </div>
            <div class="col-md-2">
                <label class="form-label">Código de Barras</label>
                <input type="text" name="cod_barras" class="form-control" value="<?= htmlspecialchars($filtros['cod_barras']) ?>" placeholder="Código">
            </div>
            <div class="col-md-2">
                <label class="form-label">Preço Mín.</label>
                <input type="number" name="preco_min" class="form-control" step="0.01" value="<?= htmlspecialchars($filtros['preco_min']) ?>" placeholder="0.00">
            </div>
            <div class="col-md-2">
                <label class="form-label">Preço Máx.</label>
                <input type="number" name="preco_max" class="form-control" step="0.01" value="<?= htmlspecialchars($filtros['preco_max']) ?>" placeholder="0.00">
            </div>
            <div class="col-md-2">
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
        <span>Total: <?= $total ?> produto(s)</span>
        <button type="button" class="btn btn-sm btn-danger" id="deleteMultiple">
            <i class="bi bi-trash"></i> Excluir selecionados
        </button>
    </div>
    <div class="card-body p-0">
        <?php if (empty($produtos)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2">Nenhum produto encontrado</p>
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
                                <th>Código de Barras</th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'preco', 'direcao' => $ordem === 'preco' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Preço <?= $ordem === 'preco' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['ordem' => 'estoque', 'direcao' => $ordem === 'estoque' && $direcao === 'ASC' ? 'DESC' : 'ASC'])) ?>" class="text-decoration-none text-dark">
                                        Estoque <?= $ordem === 'estoque' ? ($direcao === 'ASC' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="<?= $produto['id'] ?>" class="form-check-input select-item">
                                    </td>
                                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                                    <td><?= htmlspecialchars($produto['cod_barras']) ?></td>
                                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                    <td>
                                        <span class="badge <?= $produto['estoque'] > 10 ? 'bg-success' : ($produto['estoque'] > 0 ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                            <?= $produto['estoque'] ?>
                                        </span>
                                    </td>
                                    <td class="table-actions">
                                        <a href="view.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="edit.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger btn-delete" title="Excluir">
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