<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(71, 75, 78);">
    <a class="navbar-brand" href="#">
        <img src="../assets/logo.png" width="120" height="30" class="d-inline-block align-top" alt="">
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item <?= $tela == 'Clientes' ? 'active' : '' ?>">
                <a class="nav-link" href="../pages/clientes.php">Clientes</a>
            </li>
            <li class="nav-item <?= $tela == 'Pedidos' ? 'active' : '' ?>">
                <a class="nav-link" href="../pages/pedidos.php">Pedidos</a>
            </li>
            <li class="nav-item <?= $tela == 'Produtos' ? 'active' : '' ?>">
                <a class="nav-link" href="../pages/produtos.php">Produtos</a>
            </li>
        </ul>
    </div>
    <button class="btn btn-success" type="button" href="#modal-cart" data-toggle="modal" style="position:relative;" onclick="abrirCarrinho()">
        <i class="fa fa-shopping-cart"></i>
        <div id="qnt-cart"></div>
    </button>
    <button class="navbar-toggler" type="button" 
        data-toggle="collapse" data-target="#navbarSupportedContent" 
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
