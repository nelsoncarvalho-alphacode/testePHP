
@csrf
<div class="mb-3">
    <label for="NomeCliente" class="form-label">Nome</label>
    <input type="text" name="nome" value="{{ old('NomeCliente', $cliente->nome ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label for="CPF" class="form-label">CPF</label>
    <input type="text" name="cpf" value="{{ old('CPF', $cliente->cpf ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label for="Email" class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('Email', $cliente->email ?? '') }}" class="form-control" required>
</div>