<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$produtoModel = new Produto($pdo);
$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Produto não encontrado';
    header('Location: ../../index.php');
    exit;
}

$produto = $produtoModel->buscarPorId($id);

if (!$produto) {
    $_SESSION['erro'] = 'Produto não encontrado';
    header('Location: ../../index.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT pi.*, p.numero_pedido, p.data_pedido, p.status, c.nome as cliente_nome
    FROM pedido_itens pi
    INNER JOIN pedidos p ON pi.pedido_id = p.id
    INNER JOIN clientes c ON p.cliente_id = c.id
    WHERE pi.produto_id = ?
    ORDER BY p.data_pedido DESC
    LIMIT 10
");
$stmt->execute([$id]);
$pedidos_produto = $stmt->fetchAll(PDO::FETCH_ASSOC);

$titulo = 'Visualizar Produto';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-box"></i> Detalhes do Produto</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Produtos</a></li>
            <li class="breadcrumb-item active">Visualizar</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informações do Produto</h5>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong><br><?= htmlspecialchars($produto['nome']) ?></p>
                
                <?php if (!empty($produto['cod_barras'])): ?>
                    <p><strong>Código de Barras:</strong><br><?= htmlspecialchars($produto['cod_barras']) ?></p>
                <?php endif; ?>
                
                <p><strong>Preço:</strong><br>
                    <span class="text-success fs-4">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                </p>
                
                <p><strong>Estoque:</strong><br>
                    <span class="badge <?= $produto['estoque'] > 10 ? 'bg-success' : ($produto['estoque'] > 0 ? 'bg-warning text-dark' : 'bg-danger') ?> fs-6">
                        <?= $produto['estoque'] ?> unidade(s)
                    </span>
                </p>
                
                <?php if (!empty($produto['descricao'])): ?>
                    <p><strong>Descrição:</strong><br><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
                <?php endif; ?>
                
                <p class="mb-0"><strong>Cadastrado em:</strong><br><?= date('d/m/Y H:i', strtotime($produto['created_at'])) ?></p>
            </div>
            <div class="card-footer">
                <a href="edit.php?id=<?= $produto['id'] ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="delete.php?id=<?= $produto['id'] ?>" class="btn btn-danger btn-sm btn-delete">
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
                <h5 class="mb-0">Histórico de Vendas</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($pedidos_produto)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Este produto ainda não foi vendido</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Data</th>
                                    <th>Qtd.</th>
                                    <th>Valor Unit.</th>
                                    <th>Status</th>
                                    <th width="80">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos_produto as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['numero_pedido']) ?></td>
                                        <td><?= htmlspecialchars($item['cliente_nome']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($item['data_pedido'])) ?></td>
                                        <td><?= $item['quantidade'] ?></td>
                                        <td>R$ <?= number_format($item['valor_unitario'], 2, ',', '.') ?></td>
                                        <td>
                                            <?php
                                            $badge_class = [
                                                'Em Aberto' => 'bg-warning text-dark',
                                                'Pago' => 'bg-success',
                                                'Cancelado' => 'bg-danger'
                                            ];
                                            ?>
                                            <span class="badge <?= $badge_class[$item['status']] ?>">
                                                <?= htmlspecialchars($item['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="../pedidos/view.php?id=<?= $item['pedido_id'] ?>" class="btn btn-sm btn-info">
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