<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Central do Cliente</title>
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
    <link rel="stylesheet" href="css/point.css">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg themepoint static-top">
  <div class="container-fluid">
    <!-- Logo / Marca -->
    <a class="navbar-brand" href="#!">
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

    <!-- Container que colapsa/expande o menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Opções de menu (lado esquerdo) -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('index') }}">
            Home
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('solicitacoes.index') }}">
            Minhas solicitações
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('financeiro') }}">
            Financeiro
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#jornada-aprendizado">
            Aprendizado
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#faq">
            FAQ
          </a>
        </li>
      </ul>

      <!-- Informações do usuário e Botões à direita -->
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
    

    <!-- Masthead (agora com barra de pesquisa) -->
    <header class="masthead" id="barra-pesquisa">
  <div class="container position-relative">
    <div class="row justify-content-center">
      <div class="col-xl-6">
        <div class="text-center text-white">
          <!-- Título da página -->
          <h1 class="mb-5">Encontre o que você precisa!</h1>
          <!-- Formulário de pesquisa -->
          {{-- Ajuste a action para a rota de busca e o método para GET --}}
          <form class="form-subscribe" id="searchForm" action="{{ route('faqs.search') }}" method="GET">
            <div class="row">
              <div class="col">
                <input
                  class="form-control form-control-lg"
                  id="searchInput"
                  type="text"
                  name="query"
                  placeholder="Digite sua pesquisa..."
                />
              </div>
              <div class="col-auto">
                <button
                  class="btn btn-primary btn-lg"
                  id="searchButton"
                  type="submit"
                >
                  Pesquisar
                </button>
              </div>
            </div>
          </form>
          @if(session('status'))
            <p style="color: yellow;">{{ session('status') }}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</header>

    <!-- Icons Grid (mantido) -->
    <section class="features-icons bg-light text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div
              class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3"
            >
              <div class="features-icons-icon d-flex">
                <i class="bi-calendar m-auto bluepoint"></i>
              </div>
              <h3>Faça suas solicitações</h3>
              <p class="lead mb-0">
                Acesse e solicite alterações ou execução de processos, acompanhe suas solicitações e status!
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div
              class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3"
            >
              <div class="features-icons-icon d-flex">
                <i class="bi-book m-auto bluepoint"></i>
              </div>
              <h3>Tire suas dúvidas</h3>
              <p class="lead mb-0">
                Utilize nossa seção de FAQs ou nossos treinamento online para retirar todas as suas dúvidas!
              </p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="bi-headset m-auto bluepoint"></i>
              </div>
              <h3>Suporte especializado</h3>
              <p class="lead mb-0">
                Está com algum problema ou preciso de auxílio, não hesite em acionar o nosso suporte!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

<!-- Image Showcases (mantido) -->
<section class="showcase">
  <!-- As duas primeiras linhas continuam dentro de um container-fluid p-0 -->
  <div class="container-fluid p-0">
    <!-- Primeira linha -->
    <div class="row g-0">
      <div
        class="col-lg-6 order-lg-2 text-white showcase-img"
        style="background-image: url('img/img3.png')"
      ></div>
      <div class="col-lg-6 order-lg-1 my-auto showcase-text">
        <h2>Proporcionando o melhor para o cliente</h2>
        <p class="lead mb-0">
          Nosso sistema foi criado para oferecer a melhor experiência, 
          independentemente do dispositivo. Explore funcionalidades modernas 
          e um design responsivo que garante total praticidade.
        </p>
      </div>
    </div>

    <!-- Segunda linha -->
    <div class="row g-0">
      <div
        class="col-lg-6 text-white showcase-img"
        style="background-image: url('img/img2.png')"
      ></div>
      <div class="col-lg-6 my-auto showcase-text">
        <h2>Melhorando a sua experiência</h2>
        <p class="lead mb-0">
          Atualizações constantes e feedback de nossos usuários nos ajudam 
          a evoluir. Cada recurso é pensado para tornar seu dia a dia mais 
          produtivo e eficiente.
        </p>
      </div>
    </div>
  </div>

  <!-- Terceira linha: área de FAQ -->
  <!-- Envolvemos em um bloco com fundo claro e padding vertical -->
  <div class="py-5" style="background-color: #f8f9fa;" id="faq">
  <div class="container">
    <div class="row align-items-start g-4">
      <!-- Coluna da esquerda -->
      <div class="col-md-4">
        <h3 class="mb-3">Perguntas frequentes</h3>
        <p class="mb-4">
          Encontre as respostas para as suas dúvidas. Se preferir, clique no botão abaixo para
          pesquisar sua dúvida diretamente.
        </p>
        <a href="#barra-pesquisa" class="btn btn-outline-primary">
          Clique Aqui →
        </a>
      </div>

      <!-- Coluna da direita: accordion de perguntas -->
      <div class="col-md-8">
        <div class="p-4 bg-white shadow-sm rounded">
          <div class="accordion" id="faqAccordion">
            @php
              // Carrega apenas 3 FAQs do banco
              $faqs = \App\Models\Faq::take(3)->get();
            @endphp

            @forelse($faqs as $index => $faq)
              <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapse{{ $index }}"
                    aria-expanded="false"
                    aria-controls="collapse{{ $index }}"
                  >
                    {{ $faq->pergunta }}
                  </button>
                </h2>
                <div
                  id="collapse{{ $index }}"
                  class="accordion-collapse collapse"
                  aria-labelledby="heading{{ $index }}"
                  data-bs-parent="#faqAccordion"
                >
                  <div class="accordion-body">
                    {!! nl2br(e($faq->resposta)) !!}
                  </div>
                </div>
              </div>
            @empty
              <p>Nenhuma FAQ cadastrada no momento.</p>
            @endforelse

          </div>
          <!-- Mensagem para indicar que há mais perguntas -->
          @if (\App\Models\Faq::count() > 3)
            <div class="mt-3">
              <small>Existem mais perguntas frequentes. Utilize a barra de pesquisa para encontrá-las!</small>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>


</section>


    <section class="py-5" id="jornada-aprendizado">
      <div class="container">
        <!-- Título da seção -->
        <h2 class="mb-4 text-center">Jornada do Aprendizado</h2>
    
        <!-- Linha de cards -->
        <div class="row row-cols-1 row-cols-md-5 g-4">
          <!-- Card 1 -->
          <div class="col">
            <div class="card h-100 border-0 card-journey">
              <div class="card-body">
                <h5 class="card-title">Módulo Financeiro</h5>
                <p class="card-text">
                  Entenda como lidar com as finanças, pagamentos e taxas.
                </p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#!" class="link-more">Saiba mais</a>
              </div>
            </div>
          </div>
    
          <!-- Card 2 -->
          <div class="col">
            <div class="card h-100 border-0 card-journey">
              <div class="card-body">
                <h5 class="card-title">Cadastros Gerais</h5>
                <p class="card-text">
                  Aprenda como cadastrar e gerenciar usuários e dados do sistema.
                </p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#!" class="link-more">Saiba mais</a>
              </div>
            </div>
          </div>
    
          <!-- Card 3 -->
          <div class="col">
            <div class="card h-100 border-0 card-journey">
              <div class="card-body">
                <h5 class="card-title">Transações</h5>
                <p class="card-text">
                  Veja como funcionam os tipos de transferências e liquidações.
                </p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#!" class="link-more">Saiba mais</a>
              </div>
            </div>
          </div>
    
          <!-- Card 4 -->
          <div class="col">
            <div class="card h-100 border-0 card-journey">
              <div class="card-body">
                <h5 class="card-title">Operações Internas</h5>
                <p class="card-text">
                  Explore as rotinas e processos internos do sistema.
                </p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#!" class="link-more">Saiba mais</a>
              </div>
            </div>
          </div>
    
          <!-- Card 5 -->
          <div class="col">
            <div class="card h-100 border-0 card-journey">
              <div class="card-body">
                <h5 class="card-title">Relatórios</h5>
                <p class="card-text">
                  Gere relatórios, estatísticas e acompanhe métricas importantes.
                </p>
              </div>
              <div class="card-footer bg-white border-0">
                <a href="#!" class="link-more">Saiba mais</a>
              </div>
            </div>
          </div>
        </div>
    
  
    </section>
    

    <!-- Call to Action (mantido; opcional remover) -->
    <section class="call-to-action text-white text-center" id="signup">
      <div class="container position-relative">
        <div class="row justify-content-center">
          <div class="col-xl-6">
            <h2 class="mb-4">Possui alguma solicitação?</h2>
            <p class="mb-4">
              Descreva sua dúvida ou solicitação e nossa equipe retornará o mais breve possível.
            </p>
            <a href="{{route('nova')}}"><button class="btn btn-primary">Enviar Solicitação</button></a>
            <!-- Mensagens de feedback (opcionais) -->
            <div class="d-none mt-3" id="solicitacaoSucesso">
              <div class="alert alert-success">Solicitação enviada com sucesso!</div>
            </div>
            <div class="d-none mt-3" id="solicitacaoErro">
              <div class="alert alert-danger">Ocorreu um erro ao enviar. Tente novamente.</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer (mantido)-->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="#!">About</a>
              </li>
              <li class="list-inline-item">⋅</li>
              <li class="list-inline-item">
                <a href="#!">Contact</a>
              </li>
              <li class="list-inline-item">⋅</li>
              <li class="list-inline-item">
                <a href="#!">Terms of Use</a>
              </li>
              <li class="list-inline-item">⋅</li>
              <li class="list-inline-item">
                <a href="#!">Privacy Policy</a>
              </li>
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">
              &copy; Point Network 2025. All Rights Reserved.
            </p>
          </div>
          <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item me-4">
                <a href="https://www.facebook.com/pointcondominio"
                  ><i class="bi-facebook fs-3"></i
                ></a>
              </li>
              <li class="list-inline-item me-4">
                <a href="https://x.com/pointcondominio"
                  ><i class="bi-twitter fs-3"></i
                ></a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.instagram.com/point.condominio/"
                  ><i class="bi-instagram fs-3"></i
                ></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <!-- Botão de Ajuda Flutuante -->
<div id="help-button" class="help-button">
  <i class="bi bi-chat-dots-fill"></i>
</div>

<!-- Container do Chat (inicialmente oculto) -->
<div id="chat-container" class="chat-container d-none">
  <div class="chat-header">
    <span>Como podemos ajudar?</span>
    <button id="close-chat" class="close-btn">&times;</button>
  </div>
  <div class="chat-body">
    <p><strong>Point Assistente Virtual:</strong> Olá! Em que posso ajudar?</p>
  </div>
  <div class="chat-footer">
    <input type="text" placeholder="Digite sua mensagem..." />
    <button>Enviar</button>
  </div>
</div>


    <!-- Bootstrap core JS-->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    ></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
  </body>
</html>
