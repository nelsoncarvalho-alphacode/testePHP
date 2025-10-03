<header class="app-header" id="appHeader">
    <div class="container-xxl d-flex align-items-center gap-3">

        <!-- Brand -->
        <a class="brand" href="{{ route('home') }}">
            <span class="brand-badge"><i class="bi bi-briefcase-fill"></i></span>
            <span>Recrutamento</span>
        </a>

        @auth
            <!-- Nav (somente logado) -->
            <nav class="main-nav d-none d-md-flex ms-2">
                <a class="nav-link {{ request()->routeIs('vagas.*') ? 'active' : '' }}" href="{{ route('vagas.index') }}">
                    Vagas
                </a>
                <a class="nav-link {{ request()->routeIs('candidatos.*') ? 'active' : '' }}" href="{{ route('candidatos.index') }}">
                    Candidatos
                </a>
                <a class="nav-link {{ request()->routeIs('inscricoes.*') ? 'active' : '' }}" href="{{ route('inscricoes.index') }}">
                    Inscrições
                </a>
            </nav>

            <!-- Actions (somente logado) -->
            <div class="d-flex align-items-center gap-2 ms-auto">
                @yield('header-actions')

                <!-- Nome do usuário -->
                <span class="fw-bold me-2">
                    {{ Auth::user()->name }}
                </span>

                <!-- Botão Sair -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger d-none d-sm-inline-flex">
                        <i class="bi bi-box-arrow-right me-1"></i> Sair
                    </button>
                </form>

                <!-- Menu mobile -->
                <button class="btn btn-outline-secondary d-inline-flex d-md-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        @endauth

    </div>
</header>
