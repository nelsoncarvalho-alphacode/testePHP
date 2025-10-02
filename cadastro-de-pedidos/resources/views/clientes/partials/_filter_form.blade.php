<form class="mb-3" method="GET" action="{{ route('clientes.index') }}">
  <div class="row g-2">
    <div class="col-md-3">
      <input type="text" name="nome" class="form-control" placeholder="Nome" value="{{ request('nome') }}">
    </div>
    <div class="col-md-2">
      <input type="text" name="cpf" class="form-control" placeholder="CPF" value="{{ request('cpf') }}">
    </div>
    <div class="col-md-3">
      <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
    </div>
    <div class="col-md-2">
      <select name="sort" class="form-select">
        <option value="">Ordenar por...</option>
        <option value="id" {{ request('sort')=='id' ? 'selected' : '' }}>ID</option>
        <option value="nome" {{ request('sort')=='nome' ? 'selected' : '' }}>Nome</option>
        <option value="cpf" {{ request('sort')=='cpf' ? 'selected' : '' }}>CPF</option>
        <option value="email" {{ request('sort')=='email' ? 'selected' : '' }}>Email</option>
      </select>
    </div>
    <div class="col-md-1">
      <select name="direction" class="form-select">
        <option value="asc" {{ request('direction')=='asc' ? 'selected' : '' }}>ASC</option>
        <option value="desc" {{ request('direction')=='desc' ? 'selected' : '' }}>DESC</option>
      </select>
    </div>
    <div class="col-md-1 d-grid">
      <button class="btn btn-secondary">Filtrar</button>
    </div>
  </div>
</form>