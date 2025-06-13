<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';
    require '../classes/Pedido.php';
    require '../classes/PedidoItem.php';
    require '../classes/Produto.php';

    $id = $_POST['id'];

    $db = new Database();
    $conn = $db->getConnection();

    $cliente = new Cliente($conn);
    $clientes = $cliente->index();

    $pedido = new Pedido($conn);
    $pedido->setId($id);
    $pedido->read();
    
    if(!empty($id)) {
        $pedido_item = new PedidoItem($conn);
        $pedido_itens = $pedido_item->index($id);
    }
?>
<form action="../controllers/savePedido.php" method="post">
    <input type="hidden" id="edit_pedido_id" name="id" value="<?= $id ?>">
    <input type="hidden" id="edit_pedido_status" name="status" value="<?= $id == "" ? "Em Aberto" : $pedido->getStatus() ?>">
    <input type="hidden" id="edit_pedido_itens" name="itens_pedido" value='<?= json_encode($pedido_itens) ?>'>
    <input type="hidden" id="edit_pedido_total" name="total" value="<?= $pedido->getValorPedido() ?>">
    <div class="form-group">
        <label for="edit_pedido_cliente">Cliente:</label>
        <select  id="edit_pedido_cliente" name="edit_pedido_cliente" class="form-control" onclick="this.classList.remove('border', 'border-danger')"><?php
            foreach ($clientes as $cliente) {
                $selected = ($pedido->getClienteId() == $cliente['id']) ? 'selected' : '';?>
                <option value='<?=$cliente['id']?>' <?=$selected?>><?=$cliente['nome']?></option><?php
            }?>
        </select>
    </div>
    <div class="form-group">
        <label for="edit_pedido_data">Data:</label>
        <input type="date" class="form-control" id="edit_pedido_data" name="edit_pedido_data" value="<?= $id == "" ? date("Y-m-d") : $pedido->getDtPedido() ?>" onclick="this.classList.remove('border', 'border-danger')">
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <label for="">Produtos:</label>
                <table class="table table-borderless"><?php
                        foreach ($pedido_itens as $item){ 
                            $produto = new Produto($conn);
                            $produto->setId($item['produto_id']);
                            $produto->read();?>
                            <tr>
                                <td style="padding: 2px !important; width: 70%;">
                                    <input type="checkbox" name="produtos[]" value="<?=$item['id']?>" id="produto<?=$item['id']?>" checked onclick="this.classList.remove('border', 'border-danger')">
                                    <?=$produto->getNome()?><br>
                                    <span style="font-size: 10px; font-weight: bold; color: gray;">R$ <?= $item['valor_unitario']?></span>
                                </td>
                                <td style="padding: 2px !important; width: 10%; text-align: right;">R$</td>
                                <td style="padding: 2px !important; width: 20%; text-align: right;">
                                    <?= $item['valor_unitario'] * $item['quantidade']?>
                                    <div>
                                        <a role="button" class="btn btn-outline-primary btn-sm" onclick="diminuirProdutoItem(<?=$item['id']?>)"><i class="fa fa-minus"></i></a>
                                        &nbsp;<span id="qnt-spot-<?=$item['id']?>"><?= $item['quantidade'] ?></span>&nbsp;
                                        <a role="button" class="btn btn-outline-primary btn-sm" onclick="aumentarProdutoItem(<?=$item['id']?>)"><i class="fa fa-plus"></i></a>
                                    </div>
                                </td>
                            </tr><?php
                        } ?>
                        <tr>
                            <td style="padding: 2px !important;">Total:</td>
                            <td style="padding: 2px !important; vertical-align: center; text-align: right;">R$</td>
                            <td style="padding: 2px !important; vertical-align: center; text-align: right;"><?= $pedido->getValorPedido() ?></td>
                        </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center"><?php
            if($pedido->getStatus() == "Em Aberto" && count($pedido_itens)>0){ ?>
                <a role="button" class="btn btn-success col-md-4" onclick="pagarPedido(<?= $id ?>)"><i class="fa fa-money"></i> Pagar</a><?php
            }
            if($pedido->getStatus() != "Pago"){ ?>
                <a role="button" class="btn btn-danger col-md-4" onclick="cancelarPedido(<?= $id ?>)"><i class="fa fa-times"></i> Cancelar</a><?php
            }?>
        </div>
    </div>
</form>
<form onsubmit="return false">
    <div class="form-group position-relative">
        <label for="produto">Adicionar Produto:</label>
        <input type="text" id="produto" class="form-control" placeholder="Digite o nome do produto" oninput="buscarProduto()" autocomplete="off">
        <div id="listaProdutos" class="list-group position-absolute w-100" style="z-index: 999;"></div>
    </div>
</form>