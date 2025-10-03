<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Cliente.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$clienteModel = new Cliente($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Cliente não encontrado';
    header('Location: ../../index.php');
    exit;
}

$cliente = $clienteModel->buscarPorId($id);

if (!$cliente) {
    $_SESSION['erro'] = 'Cliente não encontrado';
    header('Location: ../../index.php');
    exit;
}

// Buscar pedidos do cliente
$stmt = $pdo->prepare("SELECT * FROM pedidos WHERE cliente_id = ? ORDER BY data_pedido DESC");
$stmt->execute([$id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titulo = 'Visualizar Cliente';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-person"></i> Detalhes do Cliente</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Clientes</a></li>
            <li class="breadcrumb-item active">Visualizar</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informações do Cliente</h5>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong><br><?= htmlspecialchars($cliente['nome']) ?></p>
                <p><strong>CPF:</strong><br><?= htmlspecialchars($cliente['cpf']) ?></p>
                <p><strong>Email:</strong><br><?= htmlspecialchars($cliente['email'] ?: '-') ?></p>
                <p><strong>Telefone:</strong><br><?= htmlspecialchars($cliente['telefone'] ?: '-') ?></p>
                <p><strong>Endereço:</strong><br><?= htmlspecialchars($cliente['endereco'] ?: '-') ?></p>
                <p class="mb-0"><strong>Cadastrado em:</strong><br><?= date('d/m/Y H:i', strtotime($cliente['created_at'])) ?></p>
            </div>
            <div class="card-footer">
                <a href="edit.php?id=<?= $cliente['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="delete.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm btn-delete">
                    <i class="bi bi-trash"></i> Excluir
                </a>
                <a href="index.php" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Pedidos do Cliente</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($pedidos)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Nenhum pedido encontrado</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Número</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Valor Total</th>
                                    <th width="100">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pedido['numero_pedido']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></td>
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
                                        <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                                        <td>
                                            <a href="../pedidos/view.php?id=<?= $pedido['id'] ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
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

<?php include '../layout/footer.php'; ?>