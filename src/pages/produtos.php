<?php
    $tela = 'Produtos';
    require_once '../components/head.php';
    require_once '../components/header.php';
?>
    <div>
        <div class="col-md-12" align="center">
            <h1 class="text-center">Produtos</h1>
            <div class="container" style="max-width: 1000px;">
                <div class="row g-2">
                    <div class="form-group text-left col-md-6">
                        <label for="inputBusca">Busque por Nome, Valor...</label>
                        <input type="text" id="inputBusca" class="form-control" oninput="listProdutos(1)">
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label for="inputOrdenacao">Ordenar por</label>
                        <select id="inputOrdenacao" class="form-control" onchange="listProdutos(1)">
                            <option value="nome" selected>Nome</option>
                            <option value="valor_unitario">Valor</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label for="inputDirecao">Direção</label>
                        <select id="inputDirecao" class="form-control" onchange="listProdutos(1)">
                            <option value="ASC" selected>Ascendente</option>
                            <option value="DESC">Descendente</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label for="inputLimite">Itens por pagina</label>
                        <select id="inputLimite" class="form-control" onchange="listProdutos(1)">
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="listProdutos"></div>
            <div class="mt-3 text-center" id="paginacaoProdutos"></div>
        </div>
    </div>
    <script defer>
        listProdutos();
        
        function listProdutos(pagina = 1) {
            const busca = document.getElementById('inputBusca')?.value || '';
            const ordenarPor = document.getElementById('inputOrdenacao').value;
            const direcao = document.getElementById('inputDirecao').value;
            const limite = document.getElementById('inputLimite')?.value || 20;
            
            fetch(`../components/listProdutos.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('listProdutos').innerHTML = html;
                });

            fetch(`../components/paginacaoProdutos.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('paginacaoProdutos').innerHTML = html;
                });
        }

        function editProduto(id){
            const formData = new FormData();
            formData.append('id', id);
            fetch('../components/formProduto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-title').innerHTML = "Produto:";
                document.getElementById('modal-spot').innerHTML = data;
                $("#modal-1").modal('show');
            });
        }
        function editProdutoDo(){
            const id = document.getElementById('id');
            const nome = document.getElementById('nome');
            const valor_unitario = document.getElementById('valor_unitario');

            if(nome.value == "" || valor_unitario.value == ""){
                nome.value == "" ? nome.classList.add('border', 'border-danger') : '';
                valor_unitario.value == "" ? valor_unitario.classList.add('border', 'border-danger') : '';
                toastr.error("Preencha todos os campos!");
                return;
            };
            
            const formData = new FormData();
            formData.append('id', id.value);
            formData.append('nome', nome.value);
            formData.append('valor_unitario', valor_unitario.value);
            
            fetch('../controllers/saveProduto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status == 200){
                    toastr.success("Salvo com sucesso!");
                    $("#modal-1").modal('hide');
                    listProdutos();
                } else{
                    toastr.error(data.message);
                }
            });
        }
        function deleteProduto(id, nome){
            bootbox.confirm({
                message: "Deseja realmente excluir o Produto: <br>" + nome + " ?",
                callback: function(result){
                    if (result) {
                        const formData = new FormData();
                        formData.append('id', id);
                        fetch('../controllers/deleteProduto.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            return response.text()
                        })
                        .then(data => {
                            toastr.success("Excluído com sucesso!");
                            listProdutos();
                        })
                    }
                }
            })
        }
    </script> 
<?php
    require_once '../components/footer.php';
?>