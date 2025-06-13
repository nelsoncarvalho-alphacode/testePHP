<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';
    require '../classes/Pedido.php';
    require '../classes/PedidoItem.php';
    require '../classes/Produto.php';
    require '../functions.php';

    $id = $_POST['id'];

    $db = new Database();
    $conn = $db->getConnection();

    $pedido = new Pedido($conn);
    $pedido->setId($id);
    $pedido->read();

    $pedido_item = new PedidoItem($conn);
    $pedido_itens = $pedido_item->index($id);

    $cliente = new Cliente($conn);
    $cliente->setId($pedido->getClienteId());
    $cliente->read();
?>
<div class="row">
    <div class="col-md-12">
        <div class="card-produto">
            <div class="card-produto-header">
                <div>
                    Danfe Simplificado<br>
                    1 - Saída <br>
                    <b>Número:</b> <?=$pedido->getId()?><br>
                    <b>Emissão:</b> <?=dataBrl($pedido->getDtPedido())?><br>
                </div>
                <div style="vertical-align: top; height: 100%;">
                    <?= $pedido->getStatus() != 'Cancelado' ? '<b>CHAVE DE ACESSO</b><br>' . hash('md5',$pedido->getDtPedido()) . '<br>' : '' ?>
                    <div
                        class="<?= $pedido->getStatus() != 'Cancelado' ? ($pedido->getStatus() != 'Em Aberto' ? 'alert alert-success' : 'alert alert-info') : 'alert alert-danger' ?>"
                    >
                        <?= $pedido->getStatus() ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-produto-body-cliente">
                <b>Emitente</b><br>
                <?=strtoupper($cliente->getNome())?><br>
                <b>CPF/CNPJ:</b> <?=$cliente->getCpf()?>
            </div>
            <hr>
            <table class="table table-borderless">
                <tr>
                    <th>CÓD.</th>
                    <th>DESCRIÇÃO</th>
                    <th>UN</th>
                    <th>QTD</th>
                    <th>V.UNIT</th>
                    <th>V.TOTAL</th>
                </tr><?php
                foreach ($pedido_itens as $item) {
                    $produto = new Produto($conn);
                    $produto->setId($item['produto_id']);
                    $produto->read(); ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $produto->getNome() ?></td>
                        <td><?= "un" ?></td>
                        <td><?= $item['quantidade'] ?></td>
                        <td><?= $item['valor_unitario'] ?></td>
                        <td><?= ($item['quantidade']*$item['valor_unitario']) ?></td>
                    </tr><?php
                } ?>
                <tr>
                    <td colspan="6">
                        <b>TOTAL DA NFE: </b><?= $pedido->getValorPedido() ?>
                    </td>
                </tr>
            </table>
            <hr>
            <div style="width:100%; text-align: center">
                <b>AMBIENTE DE HOMOLOGAÇÃO SEM VALOR FISCAL</b>
            </div>
        </div>
    </div>
</div>