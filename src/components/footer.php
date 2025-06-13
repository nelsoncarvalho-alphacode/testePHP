<?php
    require '../classes/Database.php';
    require '../classes/Cliente.php';

    $db = new Database();
    $conn = $db->getConnection();
    
    $cliente = new Cliente($conn);
    $clientes = $cliente->index();
?>
    <div class="modal" tabindex="3" role="dialog" id="modal-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-spot">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="3" role="dialog" id="modal-2">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-2-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-2-spot">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="3" role="dialog" id="modal-cart">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-cart-title">
                        <i class="fa fa-shopping-cart"></i> Carrinho
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-cart-spot">
                    <form method="post">
                        <input type="hidden" id="itens_pedido" name="itens_pedido" value='[]'>
                        <input type="hidden" name="total_pedido" id="total_pedido" value=''>
                        <input type="hidden" name="status" id="status" value='Em Aberto'>
                        <div class="form-group">
                            <label for="cliente">Cliente:</label>
                            <select id="cliente" name="cliente" class="form-control" onclick="this.classList.remove('border', 'border-danger')">
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
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            atualizarCarrinhoUI();
        });
        function salvarPedido(id=null){
            console.log("no salvarPedido", id);
            
            const itens_pedido_input = document.getElementById("itens_pedido");
            const total_pedido_input = document.getElementById("total_pedido");
            const cliente_input = document.getElementById("cliente");
            const data_input = document.getElementById("data");
            const status = document.getElementById("status");

            if(itens_pedido_input.value == "[]" || total_pedido_input.value == "" || cliente_input.value == "" || data_input.value == ""){
                itens_pedido_input.value == "[]" ? toastr.error("Adicione itens ao pedido para continuar") : "";
                total_pedido_input.value == ""   ? toastr.error("Adicione itens ao pedido para continuar") : "";
                cliente_input.value      == ""   ? toastr.error("Adicione o cliente do pedido") : "";
                data_input.value         == ""   ? toastr.error("Adicione a data do pedido") : "";
                return;
            }
            
            const itens = JSON.parse(document.getElementById("itens_pedido").value);
            
            const formData = new FormData();
            if(id){
                formData.append('id', id);
            } else {
                formData.append('id', '');
            }
            formData.append('itens_pedido', JSON.stringify(itens));
            formData.append('total_pedido', total_pedido_input.value);
            formData.append('cliente', cliente_input.value);
            formData.append('data', data_input.value);
            formData.append('status', status.value);
            console.log("formData");

            fetch('../controllers/savePedido.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status == 200){
                    toastr.success("Pedido realizado com sucesso!");
                    $("#modal-cart").modal('hide');
                    localStorage.removeItem("itens_pedido");
                    document.getElementById("itens_pedido").value = '[]';
                    document.getElementById("total_pedido").value = '';
                    if(window.location.href.includes("pedido.php")){
                        listPedidos();
                    }
                    atualizarCarrinhoUI();
                } else {
                    toastr.error("Erro ao realizar o pedido: " + data.message);
                }
            })
            .catch(error => {
                toastr.error("Erro ao realizar o pedido: " + error.message);
            });
        }

        function obterItensCarrinho() {
            try {
                return JSON.parse(localStorage.getItem("itens_pedido")) || [];
            } catch {
                return [];
            }
        }
        function salvarItensCarrinho(itens) {
            const json = JSON.stringify(itens);
            localStorage.setItem("itens_pedido", json);
            document.getElementById("itens_pedido").value = json;
        }
        function atualizarBadgeCarrinho(qnt) {
            const cart = document.getElementById("qnt-cart");
            if (qnt > 0) {
                cart.innerHTML = qnt;
                cart.style = `
                    display: flex;
                    position: absolute;
                    top: 0px;
                    right: 0px;
                    background-color: red;
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    justify-content: center;
                    align-items: center;
                `;
            } else{
                cart.style = `
                    display: none;
                `;
            }
        }
        function gerarHtmlItens(itens) {
            return itens.map(item => `
                <tr>
                    <td style="width: 70%; vertical-align: middle;">
                        ${item.nome}<br>
                        <span style="font-size: 10px; color: gray;">R$ ${item.valor_unitario}</span>
                    </td>
                    <td style="width: 30%; vertical-align: middle; text-align: right;">
                        <a role="button" class="btn btn-outline-primary btn-sm" onclick="diminuirItem(${item.id})"><i class="fa fa-minus"></i></a> 
                        ${item.quantidade} 
                        <a role="button" class="btn btn-outline-primary btn-sm" onclick="aumentarItem(${item.id})"><i class="fa fa-plus"></i></a>
                    </td>
                </tr>
            `).join('');
        }
        function renderizarCarrinho(itens) {
            const produtosSpot = document.getElementById("produtos-spot");
            if (itens.length > 0) {
                produtosSpot.innerHTML = gerarHtmlItens(itens);
            } else {
                produtosSpot.innerHTML = `<tr><td><div class="alert alert-info" style="margin-bottom: 0 !important;">Adicione produtos ao carrinho</div></td></tr>`;
            }
        }
        function atualizarCarrinhoUI() {
            const itens = obterItensCarrinho();
            salvarItensCarrinho(itens);
            atualizarBadgeCarrinho(itens.length);
            renderizarCarrinho(itens);
            calcularTotal(itens);
        }
        function adicionarCarrinho(id, nome, qnt, valor_unitario) {
            let itens = obterItensCarrinho();

            const index = itens.findIndex(item => item.id == id);
            if (index >= 0) {
                let novaQuantidade = parseInt(itens[index].quantidade) + 1;
                itens[index].quantidade = novaQuantidade;
            } else {
                const novoItem = {
                    id: id,
                    nome: nome,
                    quantidade: qnt,
                    valor_unitario: valor_unitario
                };
                itens.push(novoItem);
            }

            salvarItensCarrinho(itens);
            atualizarCarrinhoUI();
        }
        function abrirCarrinho() {
            const itens = obterItensCarrinho();
            calcularTotal(itens);
            renderizarCarrinho(itens);
        }
        function calcularTotal(itens) {
            let total = 0;
            const totalElement = document.getElementById("total-spot");
            const totalInput = document.getElementById("total_pedido");

            itens.forEach(item => {
                const valor = parseFloat(item.valor_unitario);
                const quantidade = parseInt(item.quantidade);
                if (!isNaN(valor) && !isNaN(quantidade)) {
                    total += valor * quantidade;
                }
            });

            const totalFormatado = total.toFixed(2).replace('.', ',');
            totalElement.innerHTML = `R$ ${totalFormatado}`;
            totalInput.value = totalFormatado;
        }
        function aumentarItem(id) {
            let itens = JSON.parse(localStorage.getItem("itens_pedido")) || [];
            const index = itens.findIndex(item => item.id == id);
            if (index >= 0) {
                const novaQuantidade = parseInt(itens[index].quantidade) + 1;
                itens[index].quantidade = novaQuantidade;
                localStorage.setItem("itens_pedido", JSON.stringify(itens));
                document.getElementById("itens_pedido").value = JSON.stringify(itens);
                atualizarCarrinhoUI();
            }
        }
        function diminuirItem(id) {
            let itens = JSON.parse(localStorage.getItem("itens_pedido")) || [];
            const index = itens.findIndex(item => item.id == id);
            if (index >= 0) {
                const novaQuantidade = parseInt(itens[index].quantidade) - 1;
                itens[index].quantidade = novaQuantidade;
                if (itens[index].quantidade <= 0) {
                    itens.splice(index, 1);
                }
                localStorage.setItem("itens_pedido", JSON.stringify(itens));
                document.getElementById("itens_pedido").value = JSON.stringify(itens);
            }
            atualizarCarrinhoUI();
        }
    </script>
</body>
</html>