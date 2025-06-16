<div class="row mb-3 align-items-center">
    <div class="col">
        <a href="{{ route('home') }}" class="text-decoration-none">
            <h1>Vagas</h1>
        </a>
    </div>
    <div class="col text-center">
        Um projeto <span class="text-warning">Laravel</span> para Alphacode!
    </div>
    <div class="col">
        <div class="d-flex justify-content-end align-items-center">
            <span>Bem-vindo(a):</span>
            @if (session('user.type') != 'empresa')
                <a href="{{ route('editCandidato', ['id' => Crypt::encrypt(session('user.id'))]) }}"
                    class="mx-2 d-flex align-items-center">
                    <span class="me-1">{{ session('user.name') }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                </a>
            @else
                <p class="text-primary fw-semibold mx-2 my-0">{{ session('user.name') }}!</p>
            @endif
            <a href="{{ route('logout') }}" class="btn btn-outline-danger px-3">
                Logout
            </a>
        </div>
    </div>
</div>
<hr>
