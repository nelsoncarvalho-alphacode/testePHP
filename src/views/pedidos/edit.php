<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Pedido.php';
require_once '../../models/Cliente.php';
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$pedidoModel = new Pedido($pdo);
$clienteModel = new Cliente($pdo);
$produtoModel = new Produto($pdo);

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['erro'] = 'Pedido não encontrado';
    header('Location: ../../index.php');
    exit;
}

$pedido = $pedidoModel->buscarPorId($id);
$itens_pedido = $pedidoModel->buscarItensPedido($id);

if (!$pedido) {
    $_SESSION['erro'] = 'Pedido não encontrado';
    header('Location: ../../index.php');
    exit;
}

// Buscar clientes e produtos
$clientes = $clienteModel->listar([], 'nome', 'ASC', 1000, 0);
$produtos = $produtoModel->listar([], 'nome', 'ASC', 1000, 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itens = [];
    $subtotal = 0;
    
    // Processar itens
    if (!empty($_POST['produto_id'])) {
        foreach ($_POST['produto_id'] as $index => $produto_id) {
            $quantidade = $_POST['quantidade'][$index] ?? 0;
            $valor_unitario = $_POST['valor_unitario'][$index] ?? 0;
            
            if ($produto_id && $quantidade > 0 && $valor_unitario > 0) {
                $item_subtotal = $quantidade * $valor_unitario;
                $itens[] = [
                    'produto_id' => $produto_id,
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valor_unitario,
                    'subtotal' => $item_subtotal
                ];
                $subtotal += $item_subtotal;
            }
        }
    }

    $desconto = $_POST['desconto'] ?? 0;
    $valor_total = $subtotal - $desconto;

    $dados = [
        'cliente_id' => $_POST['cliente_id'] ?? '',
        'data_pedido' => $_POST['data_pedido'] ?? date('Y-m-d H:i:s'),
        'status' => $_POST['status'] ?? 'Em Aberto',
        'desconto' => $desconto,
        'valor_total' => $valor_total,
        'observacoes' => $_POST['observacoes'] ?? '',
        'itens' => $itens
    ];

    $erros = [];

    if (empty($dados['cliente_id'])) {
        $erros[] = 'Selecione um cliente';
    }
    if (empty($itens)) {
        $erros[] = 'Adicione pelo menos um item ao pedido';
    }

    if (empty($erros)) {
        try {
            $pedidoModel->atualizar($id, $dados);
            $_SESSION['sucesso'] = 'Pedido atualizado com sucesso!';
            header('Location: ../../index.php');
            exit;
        } catch (Exception $e) {
            $erros[] = 'Erro ao atualizar pedido: ' . $e->getMessage();
        }
    }
}

$titulo = 'Editar Pedido';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-pencil"></i> Editar Pedido</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Pedidos</a></li>
            <li class="breadcrumb-item active">Editar</li>
        </ol>
    </nav>
</div>

<?php if (!empty($erros)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($erros as $erro): ?>
                <li><?= htmlspecialchars($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" id="formPedido">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Dados do Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número do Pedido</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($pedido['numero_pedido']) ?>" disabled>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cliente <span class="text-danger">*</span></label>
                            <select name="cliente_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?= $cliente['id'] ?>" <?= $pedido['cliente_id'] == $cliente['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cliente['nome']) ?> - <?= htmlspecialchars($cliente['cpf']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data/Hora</label>
                            <input type="datetime-local" name="data_pedido" class="form-control" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($pedido['data_pedido'])) ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Em Aberto" <?= $pedido['status'] === 'Em Aberto' ? 'selected' : '' ?>>Em Aberto</option>
                                <option value="Pago" <?= $pedido['status'] === 'Pago' ? 'selected' : '' ?>>Pago</option>
                                <option value="Cancelado" <?= $pedido['status'] === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Observações</label>
                            <textarea name="observacoes" class="form-control" rows="2"><?= htmlspecialchars($pedido['observacoes']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Itens do Pedido</h5>
                    <button type="button" class="btn btn-sm btn-success" id="addItem">
                        <i class="bi bi-plus-circle"></i> Adicionar Item
                    </button>
                </div>
                <div class="card-body">
                    <div id="itensContainer">
                        <!-- Itens serão adicionados aqui via JavaScript -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Resumo</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong id="subtotal">R$ 0,00</strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Desconto:</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" name="desconto" id="desconto" class="form-control" 
                                   step="0.01" min="0" value="<?= $pedido['desconto'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong class="text-primary fs-4" id="total">R$ 0,00</strong>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-circle"></i> Atualizar Pedido
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </div>
    </div>
</form>

<script>
const produtos = <?= json_encode($produtos) ?>;
const itensExistentes = <?= json_encode($itens_pedido) ?>;
let itemCount = 0;

document.getElementById('addItem').addEventListener('click', () => addItem());
document.getElementById('desconto').addEventListener('input', calcularTotal);

function addItem(itemData = null) {
    const container = document.getElementById('itensContainer');
    const itemDiv = document.createElement('div');
    itemDiv.className = 'item-row border rounded p-3 mb-3';
    itemDiv.dataset.index = itemCount;
    
    const produtoId = itemData ? itemData.produto_id : '';
    const quantidade = itemData ? itemData.quantidade : 1;
    const valorUnitario = itemData ? itemData.valor_unitario : '';
    
    itemDiv.innerHTML = `
        <div class="row">
            <div class="col-md-5 mb-2">
                <label class="form-label">Produto</label>
                <select name="produto_id[]" class="form-select produto-select" required onchange="updatePreco(${itemCount})">
                    <option value="">Selecione...</option>
                    ${produtos.map(p => `<option value="${p.id}" data-preco="${p.preco}" ${p.id == produtoId ? 'selected' : ''}>${p.nome} - R$ ${parseFloat(p.preco).toFixed(2)}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Qtd.</label>
                <input type="number" name="quantidade[]" class="form-control quantidade-input" min="1" value="${quantidade}" required onchange="calcularSubtotal(${itemCount})">
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Valor Unit.</label>
                <input type="number" name="valor_unitario[]" class="form-control valor-input" step="0.01" min="0" value="${valorUnitario}" required onchange="calcularSubtotal(${itemCount})">
            </div>
            <div class="col-md-2 mb-2">
                <label class="form-label">Ações</label>
                <button type="button" class="btn btn-danger w-100" onclick="removeItem(${itemCount})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
            <div class="col-12">
                <small class="text-muted">Subtotal: <span class="item-subtotal" id="item-subtotal-${itemCount}">R$ 0,00</span></small>
            </div>
        </div>
    `;
    
    container.appendChild(itemDiv);
    
    if (itemData) {
        calcularSubtotal(itemCount);
    }
    
    itemCount++;
}

function updatePreco(index) {
    const itemDiv = document.querySelector(`[data-index="${index}"]`);
    const select = itemDiv.querySelector('.produto-select');
    const valorInput = itemDiv.querySelector('.valor-input');
    
    const selectedOption = select.options[select.selectedIndex];
    if (selectedOption.value) {
        const preco = selectedOption.dataset.preco;
        valorInput.value = parseFloat(preco).toFixed(2);
        calcularSubtotal(index);
    }
}

function calcularSubtotal(index) {
    const itemDiv = document.querySelector(`[data-index="${index}"]`);
    if (!itemDiv) return;
    
    const quantidade = parseFloat(itemDiv.querySelector('.quantidade-input').value) || 0;
    const valor = parseFloat(itemDiv.querySelector('.valor-input').value) || 0;
    const subtotal = quantidade * valor;
    
    itemDiv.querySelector('.item-subtotal').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
    calcularTotal();
}

function removeItem(index) {
    const itemDiv = document.querySelector(`[data-index="${index}"]`);
    itemDiv.remove();
    calcularTotal();
}

function calcularTotal() {
    let subtotal = 0;
    
    document.querySelectorAll('.item-row').forEach(item => {
        const quantidade = parseFloat(item.querySelector('.quantidade-input').value) || 0;
        const valor = parseFloat(item.querySelector('.valor-input').value) || 0;
        subtotal += quantidade * valor;
    });
    
    const desconto = parseFloat(document.getElementById('desconto').value) || 0;
    const total = subtotal - desconto;
    
    document.getElementById('subtotal').textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
    document.getElementById('total').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
}

// Carregar itens existentes
itensExistentes.forEach(item => {
    addItem(item);
});

if (itensExistentes.length === 0) {
    addItem();
}
</script>

<?php include '../layout/footer.php'; ?>