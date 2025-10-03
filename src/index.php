<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: views/login.php');
    exit;
}

// Estatísticas do dashboard
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM clientes");
    $total_clientes = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM produtos");
    $total_produtos = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM pedidos");
    $total_pedidos = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE status = 'Em Aberto'");
    $pedidos_abertos = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT SUM(valor_total) FROM pedidos WHERE status = 'Pago'");
    $total_vendas = $stmt->fetchColumn() ?? 0;

    $stmt = $pdo->query("
        SELECT p.*, c.nome as cliente_nome 
        FROM pedidos p 
        INNER JOIN clientes c ON p.cliente_id = c.id 
        ORDER BY p.created_at DESC 
        LIMIT 5
    ");
    $pedidos_recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $erro = "Erro ao carregar estatísticas: " . $e->getMessage();
}

$titulo = 'Dashboard';
include 'views/layout/header.php';
?>

<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-0">Dashboard</h2>
        <p class="text-muted">Bem-vindo ao Pedify!</p>
    </div>
</div>

<?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h3 class="mt-3 mb-0"><?= number_format($total_clientes, 0, ',', '.') ?></h3>
                <p class="text-muted mb-0">Clientes</p>
                <a href="views/clientes/index.php" class="btn btn-sm btn-outline-primary mt-2">Ver todos</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <i class="bi bi-box fs-1 text-success"></i>
                <h3 class="mt-3 mb-0"><?= number_format($total_produtos, 0, ',', '.') ?></h3>
                <p class="text-muted mb-0">Produtos</p>
                <a href="views/produtos/index.php" class="btn btn-sm btn-outline-success mt-2">Ver todos</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <i class="bi bi-cart fs-1 text-warning"></i>
                <h3 class="mt-3 mb-0"><?= number_format($total_pedidos, 0, ',', '.') ?></h3>
                <p class="text-muted mb-0">Pedidos</p>
                <a href="views/pedidos/index.php" class="btn btn-sm btn-outline-warning mt-2">Ver todos</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <i class="bi bi-clock-history fs-1 text-info"></i>
                <h3 class="mt-3 mb-0"><?= number_format($pedidos_abertos, 0, ',', '.') ?></h3>
                <p class="text-muted mb-0">Em Aberto</p>
                <a href="views/pedidos/index.php?status=Em+Aberto" class="btn btn-sm btn-outline-info mt-2">Ver pedidos</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Total em Vendas</h5>
            </div>
            <div class="card-body text-center">
                <h2 class="text-success mb-0">R$ <?= number_format($total_vendas, 2, ',', '.') ?></h2>
                <p class="text-muted mb-0">Pedidos pagos</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock"></i> Pedidos Recentes</h5>
                <a href="views/pedidos/index.php" class="btn btn-sm btn-light">Ver todos</a>
            </div>
            <div class="card-body">
                <?php if (empty($pedidos_recentes)): ?>
                    <p class="text-muted text-center mb-0">Nenhum pedido encontrado</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos_recentes as $pedido): ?>
                                    <tr>
                                        <td>
                                            <a href="views/pedidos/view.php?id=<?= $pedido['id'] ?>">
                                                <?= htmlspecialchars($pedido['numero_pedido']) ?>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($pedido['cliente_nome']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                                        <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php
                                            $badge_class = [
                                                'Em Aberto' => 'bg-warning',
                                                'Pago' => 'bg-success',
                                                'Cancelado' => 'bg-danger'
                                            ];
                                            ?>
                                            <span class="badge <?= $badge_class[$pedido['status']] ?>">
                                                <?= htmlspecialchars($pedido['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>