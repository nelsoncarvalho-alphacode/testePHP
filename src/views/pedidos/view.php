<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Pedido.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$pedidoModel = new Pedido($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Pedido não encontrado';
    header('Location: index.php');
    exit;
}

$pedido = $pedidoModel->buscarPorId($id);
$itens = $pedidoModel->buscarItensPedido($id);

if (!$pedido) {
    $_SESSION['erro'] = 'Pedido não encontrado';
    header('Location: index.php');
    exit;
}

$titulo = 'Visualizar Pedido';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-cart"></i> Detalhes do Pedido #<?= htmlspecialchars($pedido['numero_pedido']) ?></h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Pedidos</a></li>
            <li class="breadcrumb-item active">Visualizar</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informações do Pedido</h5>
            </div>
            <div class="card-body">
                <p><strong>Número:</strong><br><?= htmlspecialchars($pedido['numero_pedido']) ?></p>
                
                <p><strong>Cliente:</strong><br>
                    <a href="../clientes/view.php?id=<?= $pedido['cliente_id'] ?>" class="text-decoration-none">
                        <i class="bi bi-person"></i> <?= htmlspecialchars($pedido['cliente_nome']) ?>
                    </a>
                </p>
                
                <p><strong>CPF:</strong><br><?= htmlspecialchars($pedido['cliente_cpf']) ?></p>
                
                <?php if (!empty($pedido['cliente_email'])): ?>
                    <p><strong>Email:</strong><br><?= htmlspecialchars($pedido['cliente_email']) ?></p>
                <?php endif; ?>
                
                <p><strong>Data do Pedido:</strong><br>
                    <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?><br>
                    <i class="bi bi-clock"></i> <?= date('H:i', strtotime($pedido['data_pedido'])) ?>
                </p>
                
                <p><strong>Status:</strong><br>
                    <?php
                    $badge_class = [
                        'Em Aberto' => 'bg-warning text-dark',
                        'Pago' => 'bg-success',
                        'Cancelado' => 'bg-danger'
                    ];
                    $icon_class = [
                        'Em Aberto' => 'bi-clock-history',
                        'Pago' => 'bi-check-circle',
                        'Cancelado' => 'bi-x-circle'
                    ];
                    ?>
                    <span class="badge <?= $badge_class[$pedido['status']] ?> fs-6">
                        <i class="bi <?= $icon_class[$pedido['status']] ?>"></i>
                        <?= htmlspecialchars($pedido['status']) ?>
                    </span>
                </p>
                
                <?php if (!empty($pedido['observacoes'])): ?>
                    <p class="mb-0"><strong>Observações:</strong><br>
                        <small class="text-muted"><?= nl2br(htmlspecialchars($pedido['observacoes'])) ?></small>
                    </p>
                <?php endif; ?>
            </div>
            <div class="card-footer">
                <a href="edit.php?id=<?= $pedido['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="delete.php?id=<?= $pedido['id'] ?>" class="btn btn-danger btn-sm btn-delete">
                    <i class="bi bi-trash"></i> Excluir
                </a>
                <a href="index.php" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-cash-stack"></i> Valores</h5>
            </div>
            <div class="card-body">
                <?php 
                $subtotal_bruto = $pedido['valor_total'] + $pedido['desconto'];
                ?>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span class="fw-bold">R$ <?= number_format($subtotal_bruto, 2, ',', '.') ?></span>
                </div>
                
                <?php if ($pedido['desconto'] > 0): ?>
                    <div class="d-flex justify-content-between mb-2 text-danger">
                        <span><i class="bi bi-tag"></i> Desconto:</span>
                        <span class="fw-bold">- R$ <?= number_format($pedido['desconto'], 2, ',', '.') ?></span>
                    </div>
                <?php endif; ?>
                
                <hr>
                
                <div class="d-flex justify-content-between align-items-center">
                    <strong class="fs-5">Total:</strong>
                    <strong class="text-success fs-3">R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Informações Adicionais</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <p class="mb-2"><strong>Criado em:</strong><br><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></p>
                    <p class="mb-0"><strong>Última atualização:</strong><br><?= date('d/m/Y H:i', strtotime($pedido['updated_at'])) ?></p>
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-basket"></i> Itens do Pedido (<?= count($itens) ?>)</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($itens)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Nenhum item neste pedido</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Produto</th>
                                    <th>Código</th>
                                    <th class="text-center">Qtd.</th>
                                    <th class="text-end">Valor Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $item_numero = 1;
                                foreach ($itens as $item): 
                                ?>
                                    <tr>
                                        <td><?= $item_numero++ ?></td>
                                        <td>
                                            <a href="../produtos/view.php?id=<?= $item['produto_id'] ?>" class="text-decoration-none">
                                                <i class="bi bi-box"></i> <?= htmlspecialchars($item['produto_nome']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <small class="text-muted"><?= htmlspecialchars($item['cod_barras'] ?: '-') ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary"><?= $item['quantidade'] ?></span>
                                        </td>
                                        <td class="text-end">R$ <?= number_format($item['valor_unitario'], 2, ',', '.') ?></td>
                                        <td class="text-end">
                                            <strong>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total dos Itens:</strong></td>
                                    <td class="text-end">
                                        <strong class="text-primary">
                                            R$ <?= number_format($subtotal_bruto, 2, ',', '.') ?>
                                        </strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Resumo Visual -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <i class="bi bi-box-seam fs-1 text-primary"></i>
                        <h3 class="mt-2"><?= count($itens) ?></h3>
                        <p class="text-muted mb-0">Itens diferentes</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-info">
                    <div class="card-body">
                        <i class="bi bi-calculator fs-1 text-info"></i>
                        <h3 class="mt-2">
                            <?php
                            $qtd_total = 0;
                            foreach ($itens as $item) {
                                $qtd_total += $item['quantidade'];
                            }
                            echo $qtd_total;
                            ?>
                        </h3>
                        <p class="text-muted mb-0">Quantidade total</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <i class="bi bi-currency-dollar fs-1 text-success"></i>
                        <h3 class="mt-2">
                            R$ <?= number_format($pedido['valor_total'] / max(1, $qtd_total), 2, ',', '.') ?>
                        </h3>
                        <p class="text-muted mb-0">Valor médio/item</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layout/footer.php'; ?>