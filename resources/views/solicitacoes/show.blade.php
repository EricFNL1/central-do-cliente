<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Detalhes da Solicitação</title>
</head>
<body>
  <main class="flex-fill">
    <div class="container mt-5">
      <h1>Detalhes da Solicitação #{{ $solicitacao->id }}</h1>
      <p><strong>Assunto:</strong> {{ $solicitacao->assunto }}</p>
      <p><strong>Descrição:</strong> {{ $solicitacao->descricao }}</p>
      <p><strong>Categoria:</strong> {{ $solicitacao->categoria }}</p>
      <p><strong>Status:</strong> {{ $solicitacao->status }}</p>
      <p><strong>Criada em:</strong> {{ $solicitacao->created_at->format('d/m/Y H:i') }}</p>
      <p>
        <strong>Previsão de Entrega:</strong>
        {{ $solicitacao->previsao_entrega ? $solicitacao->previsao_entrega->format('d/m/Y') : 'Não definida' }}
      </p>
      
      @if($solicitacao->anexo)
        <p>
          <strong>Anexo:</strong>
          <a href="{{ asset('storage/'.$solicitacao->anexo) }}" target="_blank">Ver arquivo</a>
        </p>
      @endif

      <a href="{{ route('solicitacoes.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
  </main>
</body>
</html>
