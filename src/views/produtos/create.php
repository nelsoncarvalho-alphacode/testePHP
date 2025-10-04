<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Produto.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

$produtoModel = new Produto($pdo);

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
            $produtoModel->criar($dados);
            $_SESSION['sucesso'] = 'Produto criado com sucesso!';
            header('Location: ../../index.php');
            exit;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $erros[] = 'Código de barras já cadastrado';
            } else {
                $erros[] = 'Erro ao criar produto: ' . $e->getMessage();
            }
        }
    }
}

$titulo = 'Novo Produto';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-box-seam"></i> Novo Produto</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Produtos</a></li>
            <li class="breadcrumb-item active">Novo</li>
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
                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                           placeholder="Nome do produto">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Código de Barras</label>
                    <input type="text" name="cod_barras" class="form-control" 
                           value="<?= htmlspecialchars($_POST['cod_barras'] ?? '') ?>"
                           placeholder="EAN-13 ou outro código">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Preço <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" name="preco" class="form-control" required step="0.01" min="0"
                               value="<?= htmlspecialchars($_POST['preco'] ?? '') ?>"
                               placeholder="0.00">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Estoque</label>
                    <input type="number" name="estoque" class="form-control" min="0"
                           value="<?= htmlspecialchars($_POST['estoque'] ?? '0') ?>"
                           placeholder="Quantidade em estoque">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3" placeholder="Descrição do produto"><?= htmlspecialchars($_POST['descricao'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Salvar
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php include '../layout/footer.php'; ?>