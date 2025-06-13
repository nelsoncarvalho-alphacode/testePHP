<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $db = new Database();
    $conn = $db->getConnection();

    $cliente = new Cliente($conn);

    $busca = $_GET['busca'] ?? '';
    $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $limite = isset($_GET['limite']) ? max(1, (int)$_GET['limite']) : 20;
    $ordenarPor = $_GET['ordenarPor'];
    $direcao = $_GET['direcao'];
    
    $clientes = $cliente->index($busca, $pagina, $limite, $ordenarPor, $direcao);
?>
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%; height: 100%; padding: 20px;">
    <div class="table-responsive" style="width: 100%; max-width: 1000px;  padding: 20px; border-radius: 20px; background-color: #e3f2fd;">
        <table class="table table-borderless" style="width: 100%; margin-bottom: 0 !important;">
            <tbody>
                <tr>
                    <th style="width: 15%;"></th>
                    <th style="width: 25%;">Nome</th>
                    <th style="width: 20%;">CPF</th>
                    <th style="width: 30%;">E-mail</th>
                    <th style="width: 10%;"></th>
                </tr>
                <?php foreach ($clientes as $cli) { ?>
                    <tr>
                        <td style="width: 15%;">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal-1" onclick="editCliente('<?= $cli['id'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                        </td>
                        <td style="width: 25%;"><?= $cli['nome'] ?></td>
                        <td style="width: 20%;"><?= $cli['cpf'] ?></td>
                        <td style="width: 30%;"><?= $cli['email'] ?></td>
                        <td style="width: 10%;">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteCliente('<?= $cli['id'] ?>', '<?= $cli['nome'] ?>')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="5" align="center">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-1" onclick="editCliente('')">
                            <i class="fa fa-add"></i> Adicionar
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
