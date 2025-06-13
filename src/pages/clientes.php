<?php
    $tela = 'Clientes';
    require_once '../components/head.php';
    require_once '../components/header.php';
?>
    <div>
        <div class="col-md-12" align="center">
            <h1 class="text-center">Clientes</h1>
            <div class="container" style="max-width: 1000px;">
                <div class="row g-2">
                    <div class="form-group text-left col-md-6">
                        <label>Busque por Nome, Cpf, Email</label>
                        <input type="text" id="inputBusca" class="form-control" placeholder="" oninput="listClientes(1)">
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label>Ordenar por</label>
                        <select id="inputOrdenacao" class="form-control" onchange="listClientes(1)">
                            <option value="nome" selected>Nome</option>
                            <option value="cpf">Cpf</option>
                            <option value="email">E-mail</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label>Direção</label>
                        <select id="inputDirecao" class="form-control" onchange="listClientes(1)">
                            <option value="ASC" selected>Ascendente</option>
                            <option value="DESC">Descendente</option>
                        </select>
                    </div>
                    <div class="form-group text-left col-md-2">
                        <label>Limite por pagina</label>
                        <select id="inputLimite" class="form-control" onchange="listClientes(1)">
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
            </div>
            <div id="listClientes"></div>
            <div class="mt-3 text-center" id="paginacaoClientes"></div>
        </div>
    </div>
    <script defer>
        listClientes();
        function listClientes(pagina = 1) {
            const busca = document.getElementById('inputBusca')?.value || '';
            const limite = document.getElementById('inputLimite')?.value || 20;
            const ordenarPor = document.getElementById('inputOrdenacao').value;
            const direcao = document.getElementById('inputDirecao').value;
            
            fetch(`../components/listClientes.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('listClientes').innerHTML = html;
                });

            fetch(`../components/paginacaoClientes.php?busca=${encodeURIComponent(busca)}&pagina=${pagina}&limite=${limite}&ordenarPor=${ordenarPor}&direcao=${direcao}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('paginacaoClientes').innerHTML = html;
                });
        }
        function editCliente(id){
            const formData = new FormData();
            formData.append('id', id);
            fetch('../components/formCliente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('modal-title').innerHTML = "Cliente:";
                document.getElementById('modal-spot').innerHTML = data;
            });
        }
        function editClienteDo(){
            const formData = new FormData();
            formData.append('id', document.getElementById('id').value);
            formData.append('nome', document.getElementById('nome').value);
            formData.append('cpf', document.getElementById('cpf').value);
            formData.append('email', document.getElementById('email').value);
            
            fetch('../controllers/saveCliente.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status == 200){
                    toastr.success("Salvo com sucesso!");
                    $("#modal-1").modal('hide');
                    listClientes();
                } else{
                    toastr.error(data.message);
                }
            });
        }
        function deleteCliente(id, nome){
            bootbox.confirm({
                message: "Deseja realmente excluir o cliente: <br>" + nome + " ?",
                callback: function(result){
                    if (result) {
                        const formData = new FormData();
                        formData.append('id', id);
                        fetch('../controllers/deleteCliente.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            return response.text()
                        })
                        .then(data => {
                            toastr.success("Excluído com sucesso!");
                            listClientes();
                        })
                    }
                }
            })
        }
    </script> 
<?php
    require_once '../components/footer.php';
?>