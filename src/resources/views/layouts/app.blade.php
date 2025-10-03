<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>@yield('title', 'Recrutamento')</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonte Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- CSS da aplicação -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('head')
</head>
<body>

    {{-- HEADER CENTRALIZADO --}}
    @include('layouts.header')

    @if(View::hasSection('subnav'))
    <nav class="subnav">
        <div class="container-xxl">
            <ul class="nav nav-tabs border-0">
                @yield('subnav')
            </ul>
        </div>
    </nav>
    @endif

    <main class="container-xxl page">
        @if(session('success'))
            <div class="toast align-items-center text-bg-success border-0 show mb-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast align-items-center text-bg-danger border-0 show mb-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        @endif

        <div class="page-head d-flex align-items-start align-items-md-center gap-2 flex-column flex-md-row">
            <div class="flex-fill">
                <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                <small class="text-secondary">@yield('page-subtitle')</small>
            </div>
            <div class="d-flex gap-2">
                @yield('toolbar')
            </div>
        </div>

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS da aplicação -->
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
