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
<!-- Layout flex: corpo ocupa 100% da altura da viewport e organiza em coluna -->
<body class="d-flex flex-column min-vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg themepoint static-top">
    <div class="container-fluid">
      <!-- Logo / Marca -->
      <a class="navbar-brand" href="{{ route('index') }}">
        <img src="{{ asset('img/Pointcentral.png') }}" alt="Logo" width="120" />
      </a>
      <!-- Botão 'hamburguer' -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Itens do menu -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('index') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('solicitacao') }}">Minhas solicitações</a>
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
        <!-- Botões à direita -->
        <div class="d-flex align-items-center">
          @auth
            <div class="dropdown me-2">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
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

  <!-- Conteúdo Principal dentro de <main class="flex-grow-1"> -->
  <main class="flex-grow-1">
    <div class="container my-5">
      <h1 class="mb-4">Painel Financeiro</h1>

      <!-- Seção de Resumo Financeiro -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Valor em Aberto</h5>
              <p class="card-text display-6">
                R$ {{ number_format($valorEmAberto, 2, ',', '.') }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Faturas Pendentes</h5>
              <p class="card-text display-6">{{ $faturasPendentes }}</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
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

      <!-- Tabela de Histórico de Transações -->
      <div class="card mb-5">
        <div class="card-header">
          Histórico de Transações
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($historico as $transacao)
                <tr>
                  <td>{{ optional($transacao->data_transacao)->format('d/m/Y') ?? '---' }}</td>
                  <td>{{ $transacao->descricao }}</td>
                  <td>
                    @if($transacao->tipo == 'debito')
                      - R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                    @else
                      + R$ {{ number_format($transacao->valor, 2, ',', '.') }}
                    @endif
                  </td>
                  <td>{{ ucfirst($transacao->status) }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4">Nenhuma transação registrada.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          <!-- Paginação do histórico (caso use paginate()) -->
          @if($historico->hasPages())
            <div class="d-flex justify-content-center">
              {{ $historico->links() }}
            </div>
          @endif
        </div>
      </div>

      <!-- Seção para Pagamento de Faturas (tabela com opção de pagar) -->
      <div class="mb-5">
        <h2>Pagar Fatura</h2>
        @php
          // Filtra apenas as faturas pendentes da administradora do usuário logado
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
                    <!-- Formulário para pagar a fatura -->
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

      <!-- Dashboard Financeiro com Gráfico de Pizza -->
      <div class="mb-5">
        <h2>Dashboard Financeiro</h2>
        <div style="position: relative; height: 300px; width: 100%;">
          <canvas id="financeChart"></canvas>
        </div>
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
          <!-- Paginação das faturas, se usar paginate() -->
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
  <footer class="footer bg-light mt-auto">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-start my-auto">
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
        <div class="col-lg-6 h-100 text-center text-lg-end my-auto">
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

  <!-- SweetAlert2 (para confirmação de pagamento) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Seleciona todos os formulários com a classe "form-pagar"
    const forms = document.querySelectorAll('.form-pagar');

    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        e.preventDefault(); // Impede o envio imediato

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
