<?php
// View de detalhes do usuário - perfil completo com histórico de pedidos para admin
require_once __DIR__ . '/../../bootstrap.php';
use Repository\UserRepository;
use Repository\OrderRepository;
use Util\RoutesUtil;

// Verifica permissão de administrador
session_start();
$isAdmin = $_SESSION['is_admin'] ?? 0;

if (!$isAdmin) {
    header('Location: /login');
    exit;
}

// Captura ID do usuário da URL
$routes = RoutesUtil::getRoutes();
$userId = $routes[1] ?? null;

if (!$userId) {
    header('Location: /clientes');
    exit;
}

$user = null;
$orders = [];
$totalPedidos = 0;
$totalGasto = 0;

$userRepo = new UserRepository();
$orderRepo = new OrderRepository();

$user = $userRepo->find($userId);

if (!$user) {
    header('Location: /clientes');
    exit;
}

$orders = $orderRepo->listOrdersByUser($userId);
$totalPedidos = count($orders);
$totalGasto = array_sum(array_column($orders, 'value'));
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Usuário - <?= htmlspecialchars($user['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container-fluid px-3 py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-user-circle me-2"></i>Detalhes do Usuário</h2>
                    <div>
                        <a href="/clientes" class="btn btn-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>Voltar para Usuários
                        </a>
                        <a href="/admin" class="btn btn-dark">
                            <i class="fas fa-tachometer-alt me-2"></i>Painel Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informações do Usuário -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-id-card me-2"></i>Informações Pessoais</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px; font-size: 2rem; color: white;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>#<?= htmlspecialchars($user['id']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Nome:</strong></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                            </tr>
                            <tr>
                                <td><strong>E-mail:</strong></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
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
                                <td><strong>Tipo:</strong></td>
                                <td>
                                    <?php if ($user['is_admin']): ?>
                                        <span class="badge bg-danger"><i class="fas fa-crown me-1"></i>Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><i class="fas fa-user me-1"></i>Usuário</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                        <div class="d-grid gap-2">
                            <a href="/editar-informacoes/<?= $user['id'] ?>" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Editar Usuário
                            </a>
                            <button class="btn btn-danger" onclick="deleteUser(<?= $user['id'] ?>)">
                                <i class="fas fa-trash me-2"></i>Excluir Usuário
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estatísticas e Pedidos -->
            <div class="col-md-8">
                <!-- Estatísticas -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card shadow text-center">
                            <div class="card-body">
                                <i class="fas fa-shopping-cart fa-2x text-primary mb-2"></i>
                                <h4 class="mb-0"><?= $totalPedidos ?></h4>
                                <p class="text-muted mb-0">Pedidos Feitos</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow text-center">
                            <div class="card-body">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <h4 class="mb-0">R$ <?= number_format($totalGasto, 2, ',', '.') ?></h4>
                                <p class="text-muted mb-0">Total Gasto</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow text-center">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                <h4 class="mb-0">R$ <?= $totalPedidos > 0 ? number_format($totalGasto / $totalPedidos, 2, ',', '.') : '0,00' ?></h4>
                                <p class="text-muted mb-0">Ticket Médio</p>
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
                                <p class="text-muted">Este usuário ainda não fez nenhum pedido.</p>
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
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><strong>#<?= $order['id'] ?></strong></td>
                                                <td>
                                                    <?php if (!empty($order['products'])): ?>
                                                        <small>
                                                            <?php
                                                            $productNames = array_map(function($product) {
                                                                return $product['name'] . ' (' . ($product['qty'] ?? 1) . ')';
                                                            }, $order['products']);
                                                            echo htmlspecialchars(implode(', ', array_slice($productNames, 0, 2)));
                                                            if (count($productNames) > 2) {
                                                                echo ' <span class="text-muted">+' . (count($productNames) - 2) . ' mais</span>';
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
                                                <td>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteOrder(<?= $order['id'] ?>)" title="Excluir pedido">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
    </div>

    <script>
        function deleteUser(id) {
            if (confirm('Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.')) {
                fetch(`/api/users/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Usuário excluído com sucesso!');
                        window.location.href = '/clientes';
                    }
                })
                .catch(() => {
                    alert('Erro ao excluir usuário.');
                });
            }
        }

        function deleteOrder(id) {
            if (confirm('Tem certeza que deseja excluir este pedido?')) {
                fetch(`/api/order/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert('Pedido excluído com sucesso!');
                        location.reload();
                    }
                })
                .catch(() => {
                    alert('Erro ao excluir pedido.');
                });
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>