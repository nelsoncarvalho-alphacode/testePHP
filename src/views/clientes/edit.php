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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'] ?? '',
        'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? ''),
        'email' => $_POST['email'] ?? '',
        'telefone' => $_POST['telefone'] ?? '',
        'endereco' => $_POST['endereco'] ?? ''
    ];

    $erros = [];

    if (empty($dados['nome'])) {
        $erros[] = 'Nome é obrigatório';
    }
    if (empty($dados['cpf']) || strlen($dados['cpf']) != 11) {
        $erros[] = 'CPF inválido';
    }

    if (empty($erros)) {
        try {
            $clienteModel->atualizar($id, $dados);
            $_SESSION['sucesso'] = 'Cliente atualizado com sucesso!';
            header('Location: ../../index.php');
            exit;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $erros[] = 'CPF já cadastrado';
            } else {
                $erros[] = 'Erro ao atualizar cliente: ' . $e->getMessage();
            }
        }
    }
} else {
    $_POST = $cliente;
}

$titulo = 'Editar Cliente';
include '../layout/header.php';
?>

<div class="mb-4">
    <h2><i class="bi bi-pencil"></i> Editar Cliente</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../../index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php">Clientes</a></li>
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
                    <label class="form-label">CPF <span class="text-danger">*</span></label>
                    <input type="text" name="cpf" class="form-control" id="cpf" required 
                           value="<?= htmlspecialchars($_POST['cpf']) ?>" 
                           maxlength="14" placeholder="000.000.000-00">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= htmlspecialchars($_POST['email']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" id="telefone"
                           value="<?= htmlspecialchars($_POST['telefone']) ?>" 
                           maxlength="15" placeholder="(00) 00000-0000">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Endereço</label>
                    <input type="text" name="endereco" class="form-control" 
                           value="<?= htmlspecialchars($_POST['endereco']) ?>">
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

<script>
document.getElementById('cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

document.getElementById('telefone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    }
});
</script>

<?php include '../layout/footer.php'; ?>