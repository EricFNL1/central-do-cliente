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
  <div class="row g-0">
  <!-- Lado esquerdo: imagem -->
  <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('{{ asset('img/img3.png') }}');">
  </div>
  <!-- Lado direito: últimas solicitações -->
  <div class="col-lg-6 order-lg-1 my-auto showcase-text">
  <h2>Suas Últimas Solicitações</h2>
  @php
    // Busca as 3 últimas solicitações do usuário autenticado
    $ultimasSolicitacoes = \App\Models\Solicitacao::where('user_id', Auth::id())
                          ->latest()
                          ->take(3)
                          ->get();
  @endphp

  @if($ultimasSolicitacoes->isEmpty())
    <p class="lead mb-3">Você ainda não possui solicitações.</p>
  @else
    <ul class="list-group mb-3">
      @foreach($ultimasSolicitacoes as $solicitacao)
        <li class="list-group-item">
          <strong>#{{ $solicitacao->id }}:</strong> {{ $solicitacao->assunto }}
          <br>
          @php
  // Define a cor do badge conforme o status
  $badgeClass = match($solicitacao->status) {
    'aberto' => 'bg-danger',
    'em-andamento' => 'bg-warning text-dark',
    'finalizado' => 'bg-success',
    default => 'bg-secondary',
  };
@endphp

<small class="text-muted">
  Criada em: {{ $solicitacao->created_at->format('d/m/Y') }}
  | Previsão de Entrega:
  @if($solicitacao->previsao_entrega)
    {{ $solicitacao->previsao_entrega->format('d/m/Y') }}
  @else
    Não definida
  @endif

  | Status:
  <span class="badge {{ $badgeClass }}">
    {{ ucfirst($solicitacao->status) }}
  </span>
</small>

        </li>
      @endforeach
    </ul>
  @endif

  <a href="{{ route('solicitacoes.index') }}" class="btn">
    Ver Solicitações →
  </a>
</div>
</div>

  <!-- Lado direito: últimas faturas com padding interno -->
<!-- Linha para “Últimas Faturas” no mesmo padrão de “Últimas Solicitações” -->
<div class="row g-0">
  <!-- Lado esquerdo: imagem (similar a “Últimas Solicitações”) -->
  <div class="col-lg-6 text-white showcase-img" 
       style="background-image: url('{{ asset('img/img2.png') }}');">
  </div>

  <!-- Lado direito: bloco de texto e faturas, com mesma formatação -->
 <div class="col-lg-6 my-auto showcase-text p-7">
    <h2 class="mb-3">Últimas Faturas</h2>

    @php
      // Exemplo: pega as 3 faturas mais recentes da administradora do usuário
      $admId = Auth::user()->administradora_id;
      $ultimasFaturas = \App\Models\Fatura::where('administradora_id', $admId)
                         ->orderBy('created_at', 'desc')
                         ->take(3)
                         ->get();
    @endphp

    @if($ultimasFaturas->isEmpty())
      <p class="lead mb-3">Nenhuma fatura cadastrada.</p>
    @else
      <ul class="list-group mb-3">
        @foreach($ultimasFaturas as $fatura)

          @php
            // Define a cor do badge conforme o status
            $badgeClass = match($fatura->status) {
              'pendente' => 'bg-warning text-dark',
              'pago'     => 'bg-success',
              'cancelado'=> 'bg-danger',
              default    => 'bg-secondary',
            };
          @endphp

          <li class="list-group-item">
            <strong>#{{ $fatura->id }}:</strong>
            R$ {{ number_format($fatura->valor, 2, ',', '.') }}

            <!-- Status como badge colorido -->
            <span class="badge {{ $badgeClass }}">
              {{ ucfirst($fatura->status) }}
            </span>

            <br>
            <small class="text-muted">
              Emissão:
              @if($fatura->data_emissao)
                {{ $fatura->data_emissao->format('d/m/Y') }}
              @else
                ---
              @endif

              | Vencimento:
              @if($fatura->data_vencimento)
                {{ $fatura->data_vencimento->format('d/m/Y') }}
              @else
                ---
              @endif
            </small>
          </li>
        @endforeach
      </ul>
    @endif

    <!-- Botão ou link de navegação, como no “Últimas Solicitações” -->
    <a href="{{ route('financeiro') }}" class="btn">
      Ver Faturas →
    </a>
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
    <h2 class="mb-4 text-center">Jornada do Aprendizado</h2>

    @php
      // Carrega todos os cards da tabela journeys
      $journeys = \App\Models\Journey::orderBy('order','asc')->get();
    @endphp

    <div class="row row-cols-1 row-cols-md-5 g-4">
      @forelse($journeys as $journey)
        <div class="col">
          <div class="card h-100 border-0 card-journey">
            <div class="card-body">
              <h5 class="card-title">{{ $journey->title }}</h5>
              <p class="card-text">{{ $journey->description }}</p>
            </div>
            <div class="card-footer bg-white border-0">
              @if($journey->link)
                <a href="{{ $journey->link }}" class="link-more" target="_blank">Saiba mais</a>
              @else
                <span class="text-muted">Sem link</span>
              @endif
            </div>
          </div>
        </div>
      @empty
        <p>Nenhum módulo cadastrado.</p>
      @endforelse
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
            <a href="{{route('solicitacoes.create')}}"><button class="btn btn-primary">Enviar Solicitação</button></a>
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
    <footer class="pt-5 pb-4" style="background-color: #2e2e2e; color: #fff;">
  <div class="container">
    <div class="row align-items-start gy-4">
      <!-- Coluna: Logo + Endereço (lado a lado) -->
      <div class="col-12 col-md-3">
        <!-- Agrupamos logo e texto em um flex container -->
        <div class="d-flex align-items-start">
  <!-- Logo -->
  <img
    src="img/icone-negativo.png"
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
