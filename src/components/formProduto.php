<?php
    require '../classes/Database.php';
    require '../classes/Produto.php';

    $id = $_POST['id'];

    $db = new Database();
    $conn = $db->getConnection();
    
    $produto = new Produto($conn);
    $produto->setId($id);
    $produto->read();
?>
<form action="../controllers/saveProduto.php" method="post">
    <input type="hidden" name="id" id="id" value="<?= $id ?>">
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= $produto->getNome() ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <div class="form-group">
        <label for="valor_unitario">Valor unitario:</label>
        <input type="number" class="form-control" id="valor_unitario" name="valor_unitario" value="<?= $produto->getValorUnitario() ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <a role="button" class="btn btn-primary" onclick="editProdutoDo()">Salvar</a>
</form>