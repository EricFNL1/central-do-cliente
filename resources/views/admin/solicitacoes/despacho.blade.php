<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin - Despachar Solicitação</title>
</head>
<body>
  <h1>Despachar Solicitação #{{ $solicitacao->id }}</h1>

  <form action="{{ route('admin.solicitacoes.update', $solicitacao->id) }}" method="POST">
    @csrf
    @method('PATCH')

    <div>
      <label for="funcionario_id">Atribuir a (admin):</label>
      <select name="funcionario_id" id="funcionario_id">
        <option value="">-- Selecione --</option>
        @foreach($admins as $adm)
          <option value="{{ $adm->id }}"
            {{ old('funcionario_id', $solicitacao->atendido_por) == $adm->id ? 'selected' : '' }}>
            {{ $adm->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="status">Status:</label>
      <select name="status" id="status" required>
        <option value="aberto" {{ $solicitacao->status === 'aberto' ? 'selected' : '' }}>
          Aberto
        </option>
        <option value="em-andamento" {{ $solicitacao->status === 'em-andamento' ? 'selected' : '' }}>
          Em Andamento
        </option>
        <option value="fechado" {{ $solicitacao->status === 'fechado' ? 'selected' : '' }}>
          Fechado
        </option>
      </select>
    </div>

    <button type="submit">Atualizar</button>
  </form>

  <a href="{{ route('admin.solicitacoes.index') }}">Voltar à Lista</a>
</body>
</html>
