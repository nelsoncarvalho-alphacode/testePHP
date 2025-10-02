@csrf

<div class="mb-3">
  <label for="nome" class="form-label">Nome</label>
  <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $cliente->nome ?? '') }}">
  @error('nome') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="cpf" class="form-label">CPF</label>
  <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf', $cliente->cpf ?? '') }}">
  @error('cpf') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
  <label for="email" class="form-label">Email</label>
  <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}">
  @error('email') <div class="text-danger">{{ $message }}</div> @enderror
</div>

<button class="btn btn-primary" type="submit">Salvar</button>
<a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
