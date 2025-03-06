<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Minhas Solicitações - Central do Cliente</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <!-- Bootstrap icons-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
      rel="stylesheet"
      type="text/css"
    />
    <!-- Google fonts-->
    <link
      href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic"
      rel="stylesheet"
      type="text/css"
    />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/point.css" />

    <!-- CSS para garantir altura total do body e html -->
    <style>
      html, body {
        height: 100%;
      }
    </style>
  </head>
  <!-- Define o body como um container flex, ocupando toda a altura -->
  <body class="d-flex flex-column h-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg themepoint static-top">
      <div class="container-fluid">
        <!-- Logo / Marca -->
        <a class="navbar-brand" href="index.html">
          <img src="img/Pointcentral.png" alt="Logo" width="120" />
        </a>
        <!-- Botão 'hamburguer' para telas pequenas -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{route('index')}}">
                 Home
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link isticked" href="{{route('solicitacoes.index')}}">
                Minhas solicitações
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('financeiro')}}">
                Financeiro
              </a>
            </li>
            <li class="nav-item">
  <a class="nav-link" href="{{ route('index') }}#jornada-aprendizado">
    Aprendizado
  </a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('index') }}#faq">
    FAQ
  </a>
</li>

          </ul>
          <!-- Botão de retorno para o sistema -->
          <div class="d-flex align-items-center">
  @auth
    <div class="dropdown me-2">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
      </a>
      <ul class="dropdown-menu" aria-labelledby="userDropdown">
        {{-- Se for admin, exibe o link para a rota admin --}}
        @if (Auth::user()->categoria === 'admin')
          <li>
            <a class="dropdown-item" href="{{ route('admin.panel') }}">
              Admin
            </a>
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

    <!-- Conteúdo Principal dentro de <main>, que se expande (flex-fill) -->
    <main class="flex-fill">
      <div class="container mt-5">
        <h1 class="mb-4">Minhas Solicitações</h1>
        <p>Acompanhe o status e histórico das suas solicitações abaixo.</p>
        
        <!-- Filtros e Pesquisa -->
        <div class="row mb-4">
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Pesquisar solicitação..." />
          </div>
          <div class="col-md-3">
            <select class="form-select">
              <option value="">Filtrar por status</option>
              <option value="aberto">Aberto</option>
              <option value="em-andamento">Em Andamento</option>
              <option value="fechado">Fechado</option>
            </select>
          </div>
          <div class="col-md-3">
            <button class="btn w-100">Filtrar</button>
          </div>
        </div>

        <!-- Botão Nova Solicitação -->
        <div class="mb-4 text-end">
          <!-- Ajuste o href para a página ou ação desejada -->
          <a href="{{route('solicitacoes.create')}}" class="btn">
            <i class="bi bi-plus-circle me-1"></i> Nova Solicitação
          </a>
        </div>

        <!-- Lista de Solicitações -->
        <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Assunto</th>
              <th>Data de Abertura</th>
              <th>Status</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            @forelse($solicitacoes as $solicitacao)
              <tr>
                <td>#{{ $solicitacao->id }}</td>
                <td>{{ $solicitacao->assunto }}</td>
                <td>{{ $solicitacao->created_at->format('d/m/Y H:i') }}</td>
                
                @php
                  // Exemplo simples de “badge” dependendo do status
                  $badgeClass = match($solicitacao->status) {
                    'aberto' => 'bg-danger',
                    'em-andamento' => 'bg-warning text-dark',
                    'fechado' => 'bg-success',
                    default => 'bg-secondary',
                  };
                @endphp
                
                <td>
                  <span class="badge {{ $badgeClass }}">
                    {{ ucfirst($solicitacao->status) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('solicitacoes.show', $solicitacao->id) }}" class="btn btn-sm btn-info">
                    Ver Detalhes
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5">Nenhuma solicitação encontrada.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

        <!-- Paginação -->
        <nav aria-label="Page navigation example" class="mt-4">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="#">
                1 <span class="visually-hidden">(Página atual)</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Próximo</a>
            </li>
          </ul>
        </nav>

      </div>
    </main>

    <!-- Footer com mt-auto para “colar” no fim da página -->
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
            <p class="text-muted small mb-4 mb-lg-0">
              &copy; Point Network 2025. All Rights Reserved.
            </p>
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

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
  </body>
</html>
