<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Admin - Detalhes da Solicitação</title>
</head>
<body>
  <h1>Detalhes da Solicitação #{{ $solicitacao->id }}</h1>
  
  <p><strong>Usuário:</strong> {{ $solicitacao->user->name ?? 'N/A' }}</p>
  <p><strong>Administradora:</strong> {{ $solicitacao->user->administradora->nome ?? 'N/A' }}</p>
  <p><strong>Assunto:</strong> {{ $solicitacao->assunto }}</p>
  <p><strong>Descrição:</strong> {{ $solicitacao->descricao }}</p>
  <p><strong>Categoria:</strong> {{ $solicitacao->categoria }}</p>
  <p><strong>Status:</strong> {{ $solicitacao->status }}</p>
  <p><strong>Data de Criação:</strong> {{ $solicitacao->created_at->format('d/m/Y H:i') }}</p>

  @if($solicitacao->anexo)
    <p>
      <strong>Anexo:</strong> 
      <a href="{{ asset('storage/' . $solicitacao->anexo) }}" target="_blank">Ver Arquivo</a>
    </p>
  @endif

  <a href="{{ route('admin.solicitacoes.index') }}">Voltar à Lista</a>
</body>
</html>
