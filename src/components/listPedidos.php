<?php
    require '../classes/Database.php';
    require '../classes/Pedido.php';
    require '../functions.php';

    $db = new Database();
    $conn = $db->getConnection();

    $pedido = new Pedido($conn);

    $busca = $_GET['busca'] ?? '';
    $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $limite = isset($_GET['limite']) ? max(1, (int)$_GET['limite']) : 20;
    $ordenarPor = $_GET['ordenarPor'];
    $direcao = $_GET['direcao'];
    $status = $_GET['status'];
    $data = $_GET['data'] ?? '';

    $pedidos = $pedido->index($busca, $pagina, $limite, $status, $data, $ordenarPor, $direcao);
?>
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%; height: 100%; padding: 20px;">
    <div class="table-responsive" style="width: 100%; max-width: 1000px;  padding: 20px; border-radius: 20px; background-color: #e3f2fd;">
        <table class="table table-borderless" style="width: 100%; margin-bottom: 0 !important;">
            <tbody>
                <tr>
                    <th style="width: 10%;"></th>
                    <th style="width: 20%; text-align: center;">Data</th>
                    <th style="width: 40%; text-align: center;">Cliente</th>
                    <th style="width: 15%; text-align: center;">Status</th>
                    <th style="width: 15%; text-align: center;">Valor</th>
                    <th style="width: 10%;"></th>
                </tr>
                <?php foreach ($pedidos as $ped) { ?>
                    <tr>
                        <td><?php
                            if($ped['status'] != 'Pago' && $ped['status'] != 'Cancelado'){ ?>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-2" onclick="editPedido('<?= $ped['id'] ?>')">
                                    <i class="fa fa-edit"></i>
                                </button><?php
                            } else{ ?>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-2" onclick="verPedido('<?= $ped['id'] ?>')">
                                    <i class="fa fa-eye"></i>
                                </button><?php
                            }?>
                        </td>
                        <td><?= dataBrl($ped['dt_pedido']) ?></td>
                        <td><?= $ped['nome'] ?></td>
                        <td><?= $ped['status'] ?></td>
                        <td style="display: flex; justify-content: space-between;"><div>R$</div><div><?= number_format($ped['valor_pedido'], 2, ',', '') ?></div></td>
                        <td><?php
                            if($ped['status'] != 'Pago' && $ped['status'] != 'Cancelado'){ ?>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deletePedido('<?= $ped['id'] ?>')">
                                    <i class="fa fa-trash"></i>
                                </button><?php
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
