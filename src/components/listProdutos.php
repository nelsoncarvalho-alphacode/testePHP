<?php
    require_once '../classes/Database.php';
    require_once '../classes/Produto.php';

    $database = new Database();
    $conn = $database->getConnection();

    $produto = new Produto($conn);

    $busca = $_GET['busca'] ?? '';
    $pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
    $limite = isset($_GET['limite']) ? max(1, (int)$_GET['limite']) : 20;
    $ordenarPor = $_GET['ordenarPor'];
    $direcao = $_GET['direcao'];

    $produtos = $produto->index($busca, $pagina, $limite, $ordenarPor, $direcao);
?>
<div class="table-responsive" style="width: 100%; max-width: 1000px; padding: 20px; border-radius: 20px; background-color: #e3f2fd;">
    <table class="table table-borderless" style="width: 100%; margin-bottom: 0 !important;">
        <tbody>
            <tr>
                <th style="width: 15%;"></th>
                <th style="width: 55%; text-align: center !important;">Nome</th>
                <th style="width: 20%; text-align: center !important;">Valor unitário</th>
                <th style="width: 10%;"></th>
            </tr>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td>
                        <button class="btn btn-outline-primary btn-sm" onclick="editProduto('<?= $p['id'] ?>')"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteProduto('<?= $p['id'] ?>', '<?= $p['nome'] ?>')"><i class="fa fa-trash"></i></button>
                    </td>
                    <td><?= $p['nome'] ?></td>
                    <td style="text-align: right;"><?= number_format($p['valor_unitario'], 2, ',', '') ?></td>
                    <td>
                        <button class="btn btn-outline-success btn-sm" onclick="adicionarCarrinho('<?= $p['id'] ?>','<?= addslashes($p['nome']) ?>','1','<?= $p['valor_unitario'] ?>')">
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" align="center">
                    <button class="btn btn-success btn-sm" onclick="editProduto('')">
                        <i class="fa fa-add"></i> Adicionar
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>