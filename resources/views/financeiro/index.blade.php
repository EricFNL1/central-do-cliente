<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />
  <title>Financeiro - Central do Cliente</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
  <!-- Estilos customizados -->
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
            <a class="nav-link" href="{{ route('solicitacoes.index') }}">Minhas solicitações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link isticked" href="{{ route('financeiro') }}">Financeiro</a>
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
            <i class="bi bi-arrow-left-circle me-1"></i>Voltar para o Sistema
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Conteúdo Principal -->
  <main class="flex-grow-1">
    <div class="container my-5">
      <h1 class="mb-4">Painel Financeiro</h1>

      <!-- Layout com cards empilhados e gráfico ao lado -->
      <div class="row mb-4">
           <!-- Coluna com o gráfico -->
           <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <h2>Visão Gráfica</h2>
              <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="financeChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <!-- Coluna com cards empilhados -->
        <div class="col-md-4">
          <!-- Valor em Aberto -->
          <div class="card mb-3 text-center">
            <div class="card-body">
              <h5 class="card-title">Valor em Aberto</h5>
              <p class="card-text display-6">
                R$ {{ number_format($valorEmAberto, 2, ',', '.') }}
              </p>
            </div>
          </div>
          <!-- Faturas Pendentes -->
          <div class="card mb-3 text-center">
            <div class="card-body">
              <h5 class="card-title">Faturas Pendentes</h5>
              <p class="card-text display-6">{{ $faturasPendentes }}</p>
            </div>
          </div>
          <!-- Últimas Transações -->
          <div class="card mb-3 text-center">
            <div class="card-body">
              <h5 class="card-title">Últimas Transações</h5>
              <p class="card-text display-6">
                @if($ultimasTransacoes->isNotEmpty())
                  R$ {{ number_format($ultimasTransacoes->sum('valor'), 2, ',', '.') }}
                @else
                  R$ 0,00
                @endif
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Seção para Pagamento de Faturas -->
      <div class="mb-5">
        <h2>Pagar Fatura</h2>
        @php
          $admId = Auth::user()->administradora_id;
          $faturasPendentesList = \App\Models\Fatura::where('administradora_id', $admId)
                                  ->where('status', 'pendente')
                                  ->orderBy('data_vencimento', 'asc')
                                  ->get();
        @endphp

        @if($faturasPendentesList->isEmpty())
          <p>Nenhuma fatura pendente para pagamento.</p>
        @else
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Vencimento</th>
                <th>Ação</th>
              </tr>
            </thead>
            <tbody>
              @foreach($faturasPendentesList as $fatura)
                <tr>
                  <td>{{ $fatura->id }}</td>
                  <td>{{ $fatura->descricao }}</td>
                  <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                  <td>{{ $fatura->data_vencimento->format('d/m/Y') }}</td>
                  <td>
                    <form action="{{ route('financeiro.pagar') }}" method="POST" class="form-pagar">
                      @csrf
                      <input type="hidden" name="fatura_id" value="{{ $fatura->id }}">
                      <input type="hidden" name="valor" value="{{ $fatura->valor }}">
                      <button type="submit" class="btn btn-sm">Pagar</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
      </div>

      <!-- Lista de Faturas do Usuário -->
      <div class="card mb-5">
        <div class="card-header">
          Minhas Faturas
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Emissão</th>
                <th>Vencimento</th>
                <th>Pagamento</th>
              </tr>
            </thead>
            <tbody>
              @forelse($faturas as $fatura)
                <tr>
                  <td>{{ $fatura->id }}</td>
                  <td>{{ $fatura->descricao }}</td>
                  <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                  <td>{{ $fatura->status }}</td>
                  <td>{{ $fatura->data_emissao->format('d/m/Y') }}</td>
                  <td>{{ $fatura->data_vencimento->format('d/m/Y') }}</td>
                  <td>
                    @if($fatura->data_pagamento)
                      {{ $fatura->data_pagamento->format('d/m/Y') }}
                    @else
                      ---
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7">Nenhuma fatura cadastrada.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          @if($faturas->hasPages())
            <div class="d-flex justify-content-center">
              {{ $faturas->links() }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="pt-5 pb-4" style="background-color: #2e2e2e; color: #fff;">
    <div class="container">
      <div class="row align-items-start gy-4">
        <div class="col-12 col-md-3">
          <div class="d-flex align-items-start">
            <img src="{{ asset('img/icone-negativo.png') }}" alt="Point Network Logo"
                 style="height: 40px; width: auto; margin-right: 1rem; margin-top: -1px;">
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

  <!-- Bootstrap core JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('financeChart').getContext('2d');
    const financeChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
          label: 'Pagamentos (R$)',
          data: {!! json_encode($chartData['data']) !!},
          backgroundColor: [
            'rgba(75, 192, 192, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
      }
    });
  </script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const forms = document.querySelectorAll('.form-pagar');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Confirmar Pagamento',
          text: "Deseja realmente pagar essa fatura?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sim, pagar',
          cancelButtonText: 'Cancelar',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
</body>
</html>
