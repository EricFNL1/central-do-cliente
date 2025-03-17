<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Resultados da Pesquisa - Central do Cliente</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
  <!-- Core theme CSS (includes Bootstrap) -->
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/point.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg themepoint static-top">
    <div class="container-fluid">
      <!-- Logo / Marca -->
      <a class="navbar-brand" href="{{ route('index') }}">
        <img src="{{ asset('img/Pointcentral.png') }}" alt="Logo" width="120" />
      </a>
      <!-- Botão 'hamburguer' para telas pequenas -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Menu -->
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
        <!-- Informações do usuário e Botões à direita -->
        <div class="d-flex align-items-center">
          @auth
            <div class="dropdown me-2">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                 aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu" aria-labelledby="userDropdown">
                @if (Auth::user()->categoria === 'admin')
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
      <h1 class="mb-4">Resultados da Pesquisa</h1>
      <p>Você pesquisou por: <strong>{{ $query }}</strong></p>

      @if($faqs->isEmpty())
        <p>Nenhuma FAQ encontrada para o termo informado.</p>
      @else
        <div class="accordion" id="faqSearchAccordion">
          @foreach($faqs as $index => $faq)
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading{{ $index }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                        aria-controls="collapse{{ $index }}">
                  {{ $faq->pergunta }}
                </button>
              </h2>
              <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}"
                   data-bs-parent="#faqSearchAccordion">
                <div class="accordion-body">
                  {!! nl2br(e($faq->resposta)) !!}
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <div class="mt-3">
        <a href="{{ route('index') }}" class="btn">Voltar à página inicial</a>
      </div>
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
</body>
</html>
