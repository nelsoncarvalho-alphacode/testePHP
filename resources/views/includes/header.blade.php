<div class="leftside-menu">




    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Menu</li>

            <li class="side-nav-item">
                <a href="{{route('create_purchase')}}" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span>Criar Pedido</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarClient" aria-expanded="false" aria-controls="sidebarBaseUI"
                   class="side-nav-link">
                    <i class="uil-box"></i>
                    <span> Cliente </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarClient">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('create_client')}}">Cadastro</a>
                        </li>
                        <li>
                            <a href="{{route('list_client')}}">Clientes</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarProduct" aria-expanded="false" aria-controls="sidebarBaseUI"
                   class="side-nav-link">
                    <i class="uil-box"></i>
                    <span> Produto </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarProduct">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('create_product')}}">Cadastro</a>
                        </li>
                        <li>
                            <a href="{{route('list_product')}}">Produtos</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarOrders" aria-expanded="false" aria-controls="sidebarBaseUI"
                   class="side-nav-link">
                    <i class="uil-box"></i>
                    <span> Pedido </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarOrders">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{route('list_purchase')}}">Consulta</a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
