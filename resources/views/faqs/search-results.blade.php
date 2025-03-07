<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Resultados da Pesquisa</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />

    <!-- Bootstrap (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />

    <!-- Seus estilos customizados (point.css, styles.css) -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/point.css') }}">
</head>
<body>
  <div class="container mt-5">
    <h1>Resultados da Pesquisa</h1>
    <p>Você pesquisou por: <strong>{{ $query }}</strong></p>

    @if($faqs->isEmpty())
      <p>Nenhuma FAQ encontrada para o termo informado.</p>
    @else
      <div class="accordion" id="faqSearchAccordion">
        @foreach($faqs as $index => $faq)
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
              data-bs-parent="#faqSearchAccordion"
            >
              <div class="accordion-body">
                {!! nl2br(e($faq->resposta)) !!}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <div class="mt-3">
      <a href="{{ url('index') }}">Voltar à página inicial</a>
    </div>
  </div>

  <!-- Scripts do Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
