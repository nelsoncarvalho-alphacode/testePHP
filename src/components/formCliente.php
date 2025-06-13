<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $id = $_POST['id'];

    $db = new Database();
    $conn = $db->getConnection();
    
    $cliente = new Cliente($conn);
    $cliente->setId($id);
    $cliente->read();
?>
<form action="../controllers/saveCliente.php" method="post">
    <input type="hidden" name="id" id="id" value="<?= $id ?>">
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= $cliente->getNome() ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <div class="form-group">
        <label for="cpf">CPF:</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $cliente->getCpf() ?>" data-mask="000.000.000-00" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $cliente->getEmail() ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <a role="button" class="btn btn-primary" onclick="editClienteDo()">Salvar</a>
</form>