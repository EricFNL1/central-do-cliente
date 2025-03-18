<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Nova Solicitação - Central do Cliente</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />

    <!-- Bootstrap (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />

    <!-- Seus estilos customizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/point.css') }}">

    <style>
      html, body {
        height: 100%;
      }
    </style>
</head>

<body class="d-flex flex-column h-100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg themepoint static-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('index') }}">
      <img src="{{ asset('img/Pointcentral.png') }}" alt="Logo" width="120" style="margin-top: 8px;">
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
            <a class="nav-link" href="{{ route('academia') }}">Aprendizado</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}#faq">FAQ</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
      @auth
    <div class="dropdown me-2">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
         data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
      </a>
      <ul class="dropdown-menu" aria-labelledby="userDropdown">
        {{-- Se for admin, exibe o link para a rota admin --}}
        @if (Auth::user()->categoria === 'admin')
          <li>
            <a class="dropdown-item" href="{{ route('admin.panel') }}">
              <i class="bi bi-gear me-1"></i> Admin
            </a>
          </li>
        @endif

        <li>
          <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="bi bi-person-badge me-1"></i> Editar Perfil
          </a>
        </li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
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
  <main class="flex-fill">
    <div class="container mt-5 mb-5">
      <h1 class="mb-4">Nova Solicitação</h1>

      <!-- Mensagens de erro -->
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $erro)
              <li>{{ $erro }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Mensagem de sucesso -->
      @if (session('status'))
        <div class="alert alert-success">
          {{ session('status') }}
        </div>
      @endif

      <form id="solicitacaoForm" action="{{ route('solicitacoes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label for="assunto" class="form-label">Assunto</label>
          <input type="text" class="form-control" id="assunto" name="assunto" value="{{ old('assunto') }}" placeholder="Digite o assunto da solicitação" required>
        </div>

        <div class="mb-3">
          <label for="descricao" class="form-label">Descrição</label>
          <textarea class="form-control" id="descricao" name="descricao" rows="5" placeholder="Descreva sua solicitação detalhadamente" required>{{ old('descricao') }}</textarea>
        </div>

        <div class="mb-3">
          <label for="categoria" class="form-label">Categoria</label>
          <select class="form-select" id="categoria" name="categoria" required>
            <option value="" disabled {{ old('categoria') ? '' : 'selected' }}>Selecione uma categoria</option>
            <option value="financeiro" {{ old('categoria') === 'financeiro' ? 'selected' : '' }}>Financeiro</option>
            <option value="tecnico" {{ old('categoria') === 'tecnico' ? 'selected' : '' }}>Técnico</option>
            <option value="geral" {{ old('categoria') === 'geral' ? 'selected' : '' }}>Geral</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="anexo" class="form-label">Anexo (opcional)</label>
          <input class="form-control" type="file" id="anexo" name="anexo">
        </div>

        <div class="d-flex justify-content-between">
          <a href="{{ route('solicitacoes.index') }}" class="btn">
            <i class="bi bi-arrow-left-circle me-1"></i> Voltar
          </a>
          <button type="submit" class="btn">
            <i class="bi bi-check-circle me-1"></i> Enviar Solicitação
          </button>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="pt-5 pb-4" style="background-color: #2e2e2e; color: #fff;">
  <div class="container">
    <div class="row align-items-start gy-4">
      <!-- Coluna: Logo + Endereço (lado a lado) -->
      <div class="col-12 col-md-3">
        <!-- Agrupamos logo e texto em um flex container -->
        <div class="d-flex align-items-start">
  <!-- Logo -->
  <img
    src="{{ asset('img/icone-negativo.png') }}"
    alt="Point Network Logo"
    style="
      height: 40px; 
      width: auto; 
      margin-right: 1rem; 
      margin-top: -1px; /* puxa o ícone um pouco para cima */
    "
  />
          <!-- Endereço e Contato -->
          <div style="line-height: 1.6;">
            Rua Terez de Indaiá, 225 - Centro<br />
            Mogi Mirim - SP<br />
            CEP: 13800-351
            <div class="mt-2">
              <p class="mb-0">contato@pointnetwork.com.br</p>
              <p class="mb-0">(19) 3800-0000</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Coluna: Institucional -->
      <div class="col-6 col-md-2">
        <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">
          Institucional
        </h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Sobre nós</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Termos de uso</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Política de privacidade</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Contato</a>
          </li>
        </ul>
      </div>

      <!-- Coluna: Produtos -->
      <div class="col-6 col-md-2">
        <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">
          Produtos
        </h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Point Condomínio</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Point SaaS</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Point ID</a>
          </li>
        </ul>
      </div>

      <!-- Coluna: Serviços -->
      <div class="col-6 col-md-3">
        <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">
          Serviços
        </h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Cobrança digital</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Boleto digital</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Receber em cartão de crédito</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Parking</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Seguro condominial</a>
          </li>
          <li class="mb-2">
            <a href="#!" style="color: #fff; text-decoration: none;">Crédito para condomínio</a>
          </li>
        </ul>
      </div>

      <!-- Coluna: Redes Sociais -->
      <div class="col-6 col-md-2 text-md-start text-lg-end">
        <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">
          Redes-Sociais
        </h6>
        <ul class="list-inline">
          <li class="list-inline-item me-3">
            <a href="https://www.facebook.com/pointcondominio" style="color: #fff;">
              <i class="bi-facebook fs-5"></i>
            </a>
          </li>
          <li class="list-inline-item me-3">
            <a href="https://x.com/pointcondominio" style="color: #fff;">
              <i class="bi-twitter fs-5"></i>
            </a>
          </li>
          <li class="list-inline-item">
            <a href="https://www.instagram.com/point.condominio/" style="color: #fff;">
              <i class="bi-instagram fs-5"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- Linha final: direitos reservados -->
    <div class="row mt-4">
      <div class="col-12">
        <p class="mb-0 small text-center text-md-start" style="opacity: 0.8;">
          &copy; 2025 Point Network. Todos os direitos reservados.
        </p>
      </div>
    </div>
  </div>
</footer>

  <!-- Bootstrap core JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Script para interceptar o envio do formulário com SweetAlert2 -->
  <script>
    const form = document.getElementById('solicitacaoForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault(); // Impede o envio imediato

      Swal.fire({
        title: 'Confirmar Envio',
        text: 'Deseja enviar essa solicitação?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sim, enviar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  </script>
  
  <!-- Core theme JS -->
  <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
