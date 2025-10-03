<?php
require_once __DIR__ . '/../../bootstrap.php';
use Repository\UserRepository;
use Repository\OrderRepository;

session_start();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header('Location: /login');
    exit;
}

$user = null;
$orders = [];
$totalPedidos = 0;
$totalGasto = 0;

if ($userId) {
    $userRepo = new UserRepository();
    $orderRepo = new OrderRepository();
    
    $user = $userRepo->find($userId);
    $orders = $orderRepo->listOrdersByUser($userId);
    
    $totalPedidos = count($orders);
    $totalGasto = array_sum(array_column($orders, 'value'));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="row">
            <!-- Informações Pessoais -->
            <div class="col-12 col-lg-4 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informações Pessoais</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; font-size: 2rem; color: white;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nome:</strong></td>
                                <td><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <td><strong>E-mail:</strong></td>
                                <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <td><strong>CPF:</strong></td>
                                <td><?= htmlspecialchars($user['cpf'] ?? 'Não informado') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Endereço:</strong></td>
                                <td><?= htmlspecialchars($user['endereco'] ?? 'Não informado') ?></td>
                            </tr>
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td><?= htmlspecialchars($user['id'] ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <td><strong>Tipo:</strong></td>
                                <td>
                                    <?php if ($user['is_admin'] ?? 0): ?>
                                        <span class="badge bg-danger">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Usuário</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <div class="d-grid gap-2">
                            <a href="/perfil" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Editar Perfil
                            </a>
                            <a href="/produtos" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar para Produtos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas e Pedidos -->
            <div class="col-12 col-lg-8">
                <!-- Estatísticas -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0"><?= $totalPedidos ?></h4>
                                <p class="text-muted mb-0">Total de Pedidos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <h4 class="mb-0">R$ <?= number_format($totalGasto, 2, ',', '.') ?></h4>
                                <p class="text-muted mb-0">Total Gasto</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Histórico de Pedidos -->
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Histórico de Pedidos</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($orders)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum pedido encontrado</h5>
                                <p class="text-muted">Você ainda não fez nenhum pedido.</p>
                                <a href="/produtos" class="btn btn-primary">Fazer Primeiro Pedido</a>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Produtos</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Código</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td>#<?= $order['id'] ?></td>
                                                <td>
                                                    <?php if (!empty($order['products'])): ?>
                                                        <small>
                                                            <?php
                                                            $productNames = array_map(function($product) {
                                                                return $product['name'] . ' (' . ($product['qty'] ?? 1) . ')';
                                                            }, $order['products']);
                                                            echo htmlspecialchars(implode(', ', array_slice($productNames, 0, 2)));
                                                            if (count($productNames) > 2) {
                                                                echo ' +' . (count($productNames) - 2) . ' mais';
                                                            }
                                                            ?>
                                                        </small>
                                                    <?php else: ?>
                                                        <small class="text-muted">Nenhum produto</small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong>R$ <?= number_format($order['value'], 2, ',', '.') ?></strong>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusClass = match($order['status']) {
                                                        'pendente' => 'warning',
                                                        'pago' => 'info',
                                                        'enviado' => 'primary',
                                                        'cancelado' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                    ?>
                                                    <span class="badge bg-<?= $statusClass ?>">
                                                        <?= ucfirst($order['status']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><?= htmlspecialchars($order['barcode']) ?></small>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <a href="/pedidos" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>Ver Todos os Pedidos
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>