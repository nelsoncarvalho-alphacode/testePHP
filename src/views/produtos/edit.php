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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'] ?? '',
        'cod_barras' => $_POST['cod_barras'] ?? '',
        'preco' => $_POST['preco'] ?? 0,
        'estoque' => $_POST['estoque'] ?? 0,
        'descricao' => $_POST['descricao'] ?? ''
    ];

    $erros = [];

    if (empty($dados['nome'])) {
        $erros[] = 'Nome é obrigatório';
    }
    if (empty($dados['preco']) || $dados['preco'] <= 0) {
        $erros[] = 'Preço deve ser maior que zero';
    }

    if (empty($erros)) {
        try {
            $produtoModel->atualizar($id, $dados);
            $_SESSION['sucesso'] = 'Produto atualizado com sucesso!';
            header('Location: ../../index.php');
            exit;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $erros[] = 'Código de barras já cadastrado';
            } else {
                $erros[] = 'Erro ao atualizar produto: ' . $e->getMessage();
            }
        }
    }
} else {
    $_POST = $produto;
}

$titulo = 'Editar Produto';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-pencil"></i> Editar Produto</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Produtos</a></li>
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

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome <span class="text-danger">*</span></label>
                    <input type="text" name="nome" class="form-control" required 
                           value="<?= htmlspecialchars($_POST['nome']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Código de Barras</label>
                    <input type="text" name="cod_barras" class="form-control" 
                           value="<?= htmlspecialchars($_POST['cod_barras']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="preco" class="form-control" required step="0.01" min="0"
                               value="<?= htmlspecialchars($_POST['preco']) ?>">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Estoque</label>
                    <input type="number" name="estoque" class="form-control" min="0"
                           value="<?= htmlspecialchars($_POST['estoque']) ?>">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($_POST['descricao']) ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Atualizar
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../layout/footer.php'; ?>