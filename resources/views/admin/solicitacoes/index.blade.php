<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin - Todas as Solicitações</title>
  <!-- Inclua Bootstrap / CSS conforme seu layout admin -->
</head>
<body>
  <h1>Todas as Solicitações</h1>

  @if (session('status'))
    <div style="color: green;">
      {{ session('status') }}
    </div>
  @endif

  <table border="1" cellpadding="5">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuário</th>
        <th>Administradora</th>
        <th>Assunto</th>
        <th>Categoria</th>
        <th>Status</th>
        <th>Criado em</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      @forelse($solicitacoes as $solicitacao)
        <tr>
          <td>#{{ $solicitacao->id }}</td>
          <td>{{ $solicitacao->user->name ?? 'N/A' }}</td>
          <td>{{ $solicitacao->user->administradora->nome ?? 'N/A' }}</td>
          <td>{{ $solicitacao->assunto }}</td>
          <td>{{ $solicitacao->categoria }}</td>
          <td>{{ $solicitacao->status }}</td>
          <td>{{ $solicitacao->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <a href="{{ route('admin.solicitacoes.show', $solicitacao->id) }}">Ver Detalhes</a>
            |
            <a href="{{ route('admin.solicitacoes.editDespacho', $solicitacao->id) }}">
              Despachar/Alterar Status
            </a>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8">Nenhuma solicitação encontrada.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
