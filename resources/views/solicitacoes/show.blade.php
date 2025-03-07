<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Detalhes da Solicitação - Central do Cliente</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />

  <!-- Bootstrap (CDN) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />

  <!-- CSS Customizado -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/point.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg themepoint static-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('index') }}">
        <img src="{{ asset('img/Pointcentral.png') }}" alt="Logo" width="120" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('solicitacoes.index') }}">Minhas Solicitações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('financeiro') }}">Financeiro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}#jornada-aprendizado">Aprendizado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}#faq">FAQ</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          @auth
            <div class="dropdown me-2">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" 
                 aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu" aria-labelledby="userDropdown">
                @if(Auth::user()->categoria === 'admin')
                  <li>
                    <a class="dropdown-item" href="{{ route('admin.panel') }}">Admin</a>
                  </li>
                @endif
                <li>
                  <a class="dropdown-item" href="{{ route('profile.edit') }}">Editar Perfil</a>
                </li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
            </div>
          @endauth
          <a class="btn btn-secondary me-2" href="https://pointcondominio.com.br/administradora">
            <i class="bi bi-arrow-left-circle me-1"></i>Voltar para o Sistema
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Conteúdo Principal -->
  <main class="flex-grow-1">
    <div class="container mt-5">
      <h1 class="mb-4">Detalhes da Solicitação #{{ $solicitacao->id }}</h1>
      <div class="card shadow-sm">
        <div class="card-body">
          <p><strong>Assunto:</strong> {{ $solicitacao->assunto }}</p>
          <p><strong>Descrição:</strong> {{ $solicitacao->descricao }}</p>
          <p><strong>Categoria:</strong> {{ $solicitacao->categoria }}</p>
          <p>
            <strong>Status:</strong>
            @php
              $badgeClass = match($solicitacao->status) {
                'aberto' => 'bg-danger',
                'em-andamento' => 'bg-warning text-dark',
                'finalizado' => 'bg-success',
                default => 'bg-secondary',
              };
            @endphp
            <span class="badge {{ $badgeClass }}">{{ ucfirst($solicitacao->status) }}</span>
          </p>
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
        </div>
      </div>
      <div class="mt-3">
        <a href="{{ route('solicitacoes.index') }}" class="btn">
          <i class="bi bi-arrow-left-circle me-1"></i> Voltar
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer bg-light mt-auto">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 text-center text-lg-start my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item"><a href="#!">About</a></li>
            <li class="list-inline-item">⋅</li>
            <li class="list-inline-item"><a href="#!">Contact</a></li>
            <li class="list-inline-item">⋅</li>
            <li class="list-inline-item"><a href="#!">Terms of Use</a></li>
            <li class="list-inline-item">⋅</li>
            <li class="list-inline-item"><a href="#!">Privacy Policy</a></li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Point Network 2025. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 text-center text-lg-end my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item me-4">
              <a href="https://www.facebook.com/pointcondominio"><i class="bi-facebook fs-3"></i></a>
            </li>
            <li class="list-inline-item me-4">
              <a href="https://x.com/pointcondominio"><i class="bi-twitter fs-3"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/point.condominio/"><i class="bi-instagram fs-3"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS -->
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
