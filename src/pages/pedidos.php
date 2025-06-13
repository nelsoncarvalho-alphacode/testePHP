<?php
    $tela = 'Pedidos';
    require_once '../components/head.php';
    require_once '../components/header.php';
?>
    <div>
        <div class="col-md-12" align="center">
            <h1 class="text-center">Pedidos</h1>
            <div class="container" style="max-width: 1000px;">
                <div class="row g-2">
                    <div class="form-group text-left col-md-8">
                        <label>Cliente</label>
                        <input type="text" id="inputBusca" class="form-control" placeholder="Busque pelo Cliente" oninput="listPedidos(1)">
                    </div>
                    <div class="form-group text-left col-md-4">
                        <label>Data do pedido</label>
                        <input type="date" id="inputDate" class="form-control" oninput="listPedidos(1)">
                    </div>
                    <div class="form-group text-left col-md-4">
                        <label>Status</label>
                        <select id="inputStatus" class="form-control" onchange="listPedidos(1)">
                            <option value="" selected>Todos</option>
                            <option value="Em aberto">Em aberto</option>
                            <option value="Pago">Pago</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-4">
                        <label>Ordenar por</label>
                        <select id="inputOrdenacao" class="form-control" onchange="listPedidos(1)">
                            <option value="nome" selected>Cliente</option>
                            <option value="dt_pedido">Data</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label>Direção</label>
                        <select id="inputDirecao" class="form-control" onchange="listPedidos(1)">
                            <option value="ASC" selected>Ascendente</option>
                            <option value="DESC">Descendente</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label>Limite por pagina</label>
                        <select id="inputLimite" class="form-control" onchange="listPedidos(1)">
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="listPedidos"></div>
            <div class="text-center" id="paginacaoPedidos"></div>
            <br>
        </div>
    </div>
    <script defer>
        listPedidos();
        function listPedidos(pagina = 1) {
            const busca = document.getElementById('inputBusca')?.value || '';
            const ordenarPor = document.getElementById('inputOrdenacao').value;
            const direcao = document.getElementById('inputDirecao').value;
            const data = document.getElementById('inputDate')?.value || '';
            const status = document.getElementById('inputStatus').value;
            const limite = document.getElementById('inputLimite').value;
            
            fetch(`../components/listPedidos.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&data=${data}&status=${status}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('listPedidos').innerHTML = html;
                });

            fetch(`../components/paginacaoPedidos.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&data=${data}&status=${status}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('paginacaoPedidos').innerHTML = html;
                });
        }
        function verPedido(id){
            const formData = new FormData();
            formData.append('id', id);
            fetch('../components/nfePedido.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-2-title').innerHTML = "Pedido:";
                document.getElementById('modal-2-spot').innerHTML = data;
            });
        }
        function buscarProduto() {
            const termo = document.getElementById('produto').value;
            const lista = document.getElementById('listaProdutos');
            
            if (termo.length < 2) {
                lista.innerHTML = '';
                return;
            }

            fetch(`../controllers/buscarProduto.php?termo=${encodeURIComponent(termo)}`)
            .then(res => res.json())
            .then(produtos => {
                lista.innerHTML = '';
                produtos.forEach(p => {
                    const item = document.createElement('button');
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = p.nome;
                    item.onclick = () => adicionarProduto(p);
                    lista.appendChild(item);
                });
            });
        }

        function editPedido(id){
            const formData = new FormData();
            formData.append('id', id);
            fetch('../components/formPedido.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-2-title').innerHTML = "Pedido:";
                document.getElementById('modal-2-spot').innerHTML = data;
            });
        }
        function editPedidoDo(){
            const id_input = document.getElementById("edit_pedido_id");
            const itens_pedido_input = document.getElementById("edit_pedido_itens");
            const total_pedido_input = document.getElementById("edit_pedido_total");
            const cliente_input = document.getElementById("edit_pedido_cliente");
            const data_input = document.getElementById("edit_pedido_data");
            const status = document.getElementById("edit_pedido_status");

            if(itens_pedido_input.value == "[]" || total_pedido_input.value == "" || cliente_input.value == "" || data_input.value == ""){
                itens_pedido_input.value == "[]" ? toastr.error("Adicione itens ao pedido para continuar") : "";
                total_pedido_input.value == ""   ? toastr.error("Adicione itens ao pedido para continuar") : "";
                cliente_input.value      == ""   ? toastr.error("Adicione o cliente do pedido") : "";
                data_input.value         == ""   ? toastr.error("Adicione a data do pedido") : "";
                return;
            }
            
            const itens = JSON.parse(document.getElementById("itens_pedido").value);
            total_pedido_input.value = total_pedido_input.value > 0 ? total_pedido_input.value : 0;
            const formData = new FormData();
            formData.append('id', id_input.value);
            formData.append('itens_pedido', JSON.stringify(itens));
            formData.append('total_pedido', total_pedido_input.value);
            formData.append('cliente', cliente_input.value);
            formData.append('data', data_input.value);
            formData.append('status', status.value);
            console.log("formData", formData);

            fetch('../controllers/savePedido.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status == 200){
                    toastr.success("Pedido atualizado com sucesso!");
                    listPedidos();
                    editPedido(id_input.value);
                } else {
                    toastr.error("Erro ao atualizar o pedido: " + data.message);
                }
            })
            .catch(error => {
                toastr.error("Erro ao atualizar o pedido: " + error.message);
            });
        }
        function deletePedido(id){
            bootbox.confirm({
                message: "Deseja realmente excluir o Pedido: <br>" + id + " ?",
                callback: function(result){
                    if (result) {
                        const formData = new FormData();
                        formData.append('id', id);
                        fetch('../controllers/deletePedido.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            return response.text()
                        })
                        .then(data => {
                            toastr.success("Excluído com sucesso!");
                            listPedidos();
                        })
                    }
                }
            })
        }

        function aumentarProdutoItem(id) {
            let raw = document.getElementById("edit_pedido_itens")?.value || "[]";
            let itens = [];
            try {
                itens = JSON.parse(raw);
            } catch {
                itens = [];
            }

            const index = itens.findIndex(item => item.id == id);
            if (index >= 0) {
                itens[index].quantidade++;

                const totalInput = document.getElementById("edit_pedido_total");
                let total = parseFloat(totalInput?.value || "0");
                total += parseFloat(itens[index].valor_unitario);
                totalInput.value = total.toFixed(2);
            }
            console.log("Antes:", document.getElementById("edit_pedido_itens").value);
            document.getElementById("edit_pedido_itens").value = JSON.stringify(itens);
            console.log("Depois:", document.getElementById("edit_pedido_itens").value);
            
            editPedidoDo();
        }
        function diminuirProdutoItem(id) {
            let raw = document.getElementById("edit_pedido_itens")?.value || "[]";
            let itens = [];
            try {
                itens = JSON.parse(raw);
            } catch {
                itens = [];
            }

            const index = itens.findIndex(item => item.id == id);
            if (index >= 0) {
                const valorUnitario = parseFloat(itens[index].valor_unitario);
                const totalInput = document.getElementById("edit_pedido_total");
                let total = parseFloat(totalInput?.value || "0");

                itens[index].quantidade--;
                total -= valorUnitario;

                if(itens[index].quantidade <= 0) {
                    itens.splice(index, 1);

                    const formData = new FormData();
                    formData.append('id', id);
                    
                    fetch("../controllers/deletePedidoItem.php", {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Erro ao excluir item do pedido");
                        }
                        return response.json();
                    })
                    .then(data => {
                        toastr.success("Item excluído com sucesso");
                    })
                    .catch(error => {
                        toastr.error("Erro ao excluir item");
                    });
                }

                totalInput.value = total.toFixed(2);
            }
            document.getElementById("edit_pedido_itens").value = JSON.stringify(itens);
            editPedidoDo();
        }

        function pagarPedido(id) {
            bootbox.confirm({
                message: "Não será possivel reverter essa ação! Deseja realmente pagar o pedido: <br>" + id + " ?",
                callback: function(result){
                    if (result) {
                        const formData = new FormData();
                        formData.append('id', id);
                        formData.append('status', 'Pago');
                        fetch('../controllers/statusPedido.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status == 200){
                                toastr.success("Pedido pago com sucesso!");
                                listPedidos();
                                $('#modal-2').modal('hide');
                            } else {
                                toastr.error("Erro ao pagar o pedido");
                            }
                        })
                        .catch(error => {
                            toastr.error("Erro ao pagar o pedido");
                        });
                    }
                }
            })
        }

        function cancelarPedido(id) {
            bootbox.confirm({
                message: "Não será possivel reverter essa ação! Deseja realmente cancelar o pedido: <br>" + id + " ?",
                callback: function(result){
                    if (result) {
                        const formData = new FormData();
                        formData.append('id', id);
                        formData.append('status', 'Cancelado');
                        fetch('../controllers/statusPedido.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.status == 200){
                                toastr.success("Pedido cancelado com sucesso!");
                                listPedidos();
                                $('#modal-2').modal('hide');
                            } else {
                                toastr.error("Erro ao cancelar o pedido");
                            }
                        })
                        .catch(error => {
                            toastr.error("Erro ao cancelar o pedido");
                        });
                    }
                }
            })

        }

        function adicionarProduto(produto) {
            let raw = document.getElementById("itens_pedido")?.value || "[]";
            let itens = [];
            try {
                itens = JSON.parse(raw);
            } catch {
                itens = [];
            }

            const index = itens.findIndex(item => item.id == produto.id);
            if (index >= 0) {
                itens[index].quantidade++;
            } else {
                itens.push({ ...produto, quantidade: 1 });
            }

            document.getElementById("itens_pedido").value = JSON.stringify(itens);
            atualizarListaProdutosDoPedido();

            toastr.success(`Produto "${produto.nome}" adicionado ao pedido!`);
            document.getElementById('produto').value = '';
            document.getElementById('listaProdutos').innerHTML = '';
        }
    </script> 
<?php
    require_once '../components/footer.php';
?>