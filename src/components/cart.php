<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $cliente = new Cliente($conn);
    $clientes = $cliente->index();
?>
<form method="POST">
    <input type="hidden" id="itens_pedido" name="itens_pedido" value='[]'>
    <input type="hidden" name="total_pedido" id="total_pedido" value=''>
    <input type="hidden" name="status" id="status" value='Em Aberto'>
    <div class="form-group">
        <label for="cliente">Cliente:</label>
        <select  id="cliente" name="cliente" class="form-control" onclick="this.classList.remove('border', 'border-danger')">
            <option value="">Selecione o cliente...</option><?php
            foreach ($clientes as $cliente) { ?>
                <option value='<?=$cliente['id']?>'><?=$cliente['nome']?></option><?php
            }?>
        </select>
    </div>
    <div class="form-group">
        <label for="data">Data:</label>
        <input type="date" class="form-control" id="data" name="data" value="<?= date("Y-m-d") ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="">Produtos:</label>
            <table class="table" id="produtos-spot">
                <tr><td><div class="alert alert-info" style="margin-bottom: 0 !important;">Adicione produtos ao carrinho</div></td></tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table" id="itens-spot">
                <tr>
                    <td style="width: 80%;">Total:</td>
                    <td style="width: 20%; text-align: right;" id="total-spot"></td>
                </tr>
            </table>
        </div>
    </div>
    <a role="button" class="btn btn-primary" onclick="salvarPedido()">Fazer pedido</a>
</form>