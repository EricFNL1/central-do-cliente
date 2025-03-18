<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Treinamentos - Central do Cliente</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" />
    <!-- Core theme CSS (inclui Bootstrap)-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/point.css') }}" />
  </head>
  <body>
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
          <!-- Menu -->
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
              <a class="nav-link isticked" href="">Treinamentos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#faq">FAQ</a>
            </li>
          </ul>
          <!-- Dados do usuário e botões -->
          <div class="d-flex align-items-center">
            @auth
              <div class="dropdown me-2">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
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
              <i class="bi bi-arrow-left-circle me-1"></i> Voltar para o Sistema
            </a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Cabeçalho com vídeo de fundo -->
    <header class="masthead2" id="barra-pesquisa">
      <div class="container position-relative">
        <div class="row justify-content-center">
          <div class="col-xl-6">
            <div class="text-center text-white">
              <h1 class="mb-5">Descubra nossos Treinamentos</h1>
              <p class="lead">Aprenda novas habilidades e desenvolva seu potencial com nossos cursos e treinamentos online.</p>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Seção de Treinamentos com Categorias -->
    <section class="features-icons bg-light text-center" id="treinamentos">
      <div class="container">
        <h1 class="mb-5">Encontre o que você precisa!</h1>
        <form class="form-subscribe mb-5" id="searchForm" action="{{ route('faqs.search') }}" method="GET">
          <div class="row">
            <div class="col">
              <input class="form-control form-control-lg" id="searchInput" type="text" name="query" placeholder="Digite sua pesquisa..." />
            </div>
            <div class="col-auto">
              <button class="btn btn-lg" id="searchButton" type="submit">Pesquisar</button>
            </div>
          </div>
        </form>
        <h2 class="mb-5">Nossos Treinamentos</h2>
        <div class="row">
          @forelse($categorias as $categoria)
            <div class="col-lg-4">
              <div class="card mb-4">
                @if($categoria->imagem)
                  <img src="{{ asset('storage/' . $categoria->imagem) }}" alt="{{ $categoria->nome }}" class="card-img-top">
                  <!-- Se preferir usar Storage::url(), descomente a linha abaixo e comente a anterior -->
                  <!-- <img src="{{ Storage::url($categoria->imagem) }}" alt="{{ $categoria->nome }}" class="card-img-top"> -->
                @else
                  <img src="{{ asset('img/placeholder.png') }}" alt="Sem imagem" class="card-img-top">
                @endif

                <div class="card-body">
                  <h3 class="card-title">{{ $categoria->nome }}</h3>

                  <!-- Botão para abrir/fechar o bloco de treinamentos -->
                  <button class="btn  mb-3" type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#collapseCategoria-{{ $categoria->id }}"
                          aria-expanded="false"
                          aria-controls="collapseCategoria-{{ $categoria->id }}">
                    Ver Treinamentos
                  </button>

                  <!-- Conteúdo que expande/recolhe -->
                  <div class="collapse" id="collapseCategoria-{{ $categoria->id }}">
                    @if($categoria->treinamentos->count() > 0)
                      <!-- Se quiser exibir cada treinamento em um Accordion separado: -->
                      <div class="accordion" id="accordionCategoria-{{ $categoria->id }}">
                        @foreach($categoria->treinamentos as $index => $treinamento)
                          <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $categoria->id }}-{{ $index }}">
                              <button class="accordion-button collapsed" type="button"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#collapse-{{ $categoria->id }}-{{ $index }}"
                                      aria-expanded="false"
                                      aria-controls="collapse-{{ $categoria->id }}-{{ $index }}">
                                {{ $treinamento->titulo }}
                              </button>
                            </h2>
                            <div id="collapse-{{ $categoria->id }}-{{ $index }}"
                                 class="accordion-collapse collapse"
                                 aria-labelledby="heading-{{ $categoria->id }}-{{ $index }}"
                                 data-bs-parent="#accordionCategoria-{{ $categoria->id }}">
                              <div class="accordion-body" style="max-height: 200px; overflow-y: auto;">
                                <p>{{ $treinamento->descricao }}</p>
                                @if($treinamento->link)
                                  <a href="{{ $treinamento->link }}" class="btn btn-sm" target="_blank">Acessar Treinamento</a>
                                @endif
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>

                      <!-- Se preferir uma listagem simples, sem accordion:
                      @foreach($categoria->treinamentos as $treinamento)
                        <div class="text-start mb-2">
                          <h5>{{ $treinamento->titulo }}</h5>
                          <p>{{ $treinamento->descricao }}</p>
                          @if($treinamento->link)
                            <a href="{{ $treinamento->link }}" class="btn btn-primary btn-sm" target="_blank">Acessar Treinamento</a>
                          @endif
                        </div>
                      @endforeach
                      -->
                    @else
                      <p>Nenhum treinamento disponível nesta categoria.</p>
                    @endif
                  </div>
                  <!-- Fim do bloco collapse -->
                </div>
              </div>
            </div>
          @empty
            <p class="lead">Nenhuma categoria com treinamentos disponível no momento.</p>
          @endforelse
        </div>
      </div>
    </section>

    <!-- Seção de FAQ -->
    <section class="py-5 bg-white" id="faq">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2>FAQ - Perguntas Frequentes</h2>
            <div class="accordion" id="faqAccordion">
              @php
                $faqs = \App\Models\Faq::take(3)->get();
              @endphp
              @forelse($faqs as $index => $faq)
                <div class="accordion-item">
                  <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                      {{ $faq->pergunta }}
                    </button>
                  </h2>
                  <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      {!! nl2br(e($faq->resposta)) !!}
                    </div>
                  </div>
                </div>
              @empty
                <p>Nenhuma FAQ cadastrada no momento.</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="pt-5 pb-4" style="background-color: #2e2e2e; color: #fff;">
      <div class="container">
        <div class="row align-items-start gy-4">
          <div class="col-12 col-md-3">
            <div class="d-flex align-items-start">
              <img src="{{ asset('img/icone-negativo.png') }}" alt="Point Network Logo" style="height: 40px; width: auto; margin-right: 1rem; margin-top: -1px;">
              <div style="line-height: 1.6;">
                Rua Terez de Indaiá, 225 - Centro<br>
                Mogi Mirim - SP<br>
                CEP: 13800-351
                <div class="mt-2">
                  <p class="mb-0">contato@pointnetwork.com.br</p>
                  <p class="mb-0">(19) 3800-0000</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-2">
            <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">Institucional</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Sobre nós</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Termos de uso</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Política de privacidade</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Contato</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-2">
            <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">Produtos</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Point Condomínio</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Point SaaS</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Point ID</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-3">
            <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">Serviços</h6>
            <ul class="list-unstyled mb-0">
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Cobrança digital</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Boleto digital</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Receber em cartão de crédito</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Parking</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Seguro condominial</a></li>
              <li class="mb-2"><a href="#!" style="color: #fff; text-decoration: none;">Crédito para condomínio</a></li>
            </ul>
          </div>
          <div class="col-6 col-md-2 text-md-start text-lg-end">
            <h6 class="fw-bold mb-3" style="text-transform: uppercase; font-size: 0.9rem;">Redes-Sociais</h6>
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
        <div class="row mt-4">
          <div class="col-12">
            <p class="mb-0 small text-center text-md-start" style="opacity: 0.8;">
              &copy; 2025 Point Network. Todos os direitos reservados.
            </p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <script src="{{ asset('js/scripts.js') }}"></script>
  </body>
</html>
