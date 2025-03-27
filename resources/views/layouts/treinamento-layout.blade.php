<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Área de Treinamentos')</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Seu CSS customizado, se houver -->
  <link rel="stylesheet" href="{{ asset('css/treinamento.css') }}">
  @yield('styles')
</head>
<body>
  <!-- Header / Navbar específico -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ route('treinamentos.index') }}">Treinamentos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTreinamentos">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTreinamentos">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('treinamentos.index') }}">Dashboard</a>
            </li>
            <!-- Adicione mais links conforme necessário -->
            <li class="nav-item">
              <a class="nav-link" href="{{ route('profile.index') }}">Perfil</a>
            </li>
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link nav-link">Sair</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Layout com Sidebar e Conteúdo -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar (se desejar, pode ser dinâmico) -->
      <aside class="col-md-3 col-lg-2 bg-light sidebar py-4">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('treinamentos.index') }}" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Meus Treinamentos</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Categorias</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Configurações</a>
          </li>
        </ul>
      </aside>

      <!-- Conteúdo principal -->
      <main class="col-md-9 col-lg-10 py-4">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3">
    &copy; {{ date('Y') }} Área de Treinamentos. Todos os direitos reservados.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
