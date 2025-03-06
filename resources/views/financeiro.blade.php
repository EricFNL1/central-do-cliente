<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <title>Financeiro - Central do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/point.css">
  </head>
  <body>
    <!-- Cabeçalho (reutilize o mesmo da Central do Cliente) -->
    <nav class="navbar navbar-expand-lg themepoint static-top">
      <div class="container-fluid">
        <!-- Logo / Marca -->
        <a class="navbar-brand" href="#!">
          <img src="img/Pointcentral.png" alt="Logo" width="120" />
        </a>
        <!-- Botão 'hamburguer' para telas pequenas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Container que colapsa/expande o menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Opções de menu (lado esquerdo) -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="{{route('index')}}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('solicitacao')}}">Minhas solicitações</a>
            </li>
            <li class="nav-item">
              <a class="nav-link isticked" href="{{route('financeiro')}}">Financeiro</a>
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
          <!-- Botões à direita -->
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

    <!-- Conteúdo Principal -->
    <div class="container my-5">
      <h1 class="mb-4">Painel Financeiro</h1>

      <!-- Seção de Resumo Financeiro -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Saldo Atual</h5>
              <p class="card-text display-6">R$ 1.200,00</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Faturas Pendentes</h5>
              <p class="card-text display-6">3</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Últimas Transações</h5>
              <p class="card-text display-6">+ R$ 500,00</p>
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
              <tr>
                <td>01/03/2025</td>
                <td>Pagamento Boleto #1234</td>
                <td>R$ -150,00</td>
                <td>Pago</td>
              </tr>
              <tr>
                <td>28/02/2025</td>
                <td>Depósito de Crédito</td>
                <td>R$ +200,00</td>
                <td>Confirmado</td>
              </tr>
              <!-- Outras linhas de transações -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Seção para Pagamento de Faturas -->
      <div class="mb-5">
        <h2>Pagar Fatura</h2>
        <form>
          <div class="mb-3">
            <label for="faturaId" class="form-label">ID da Fatura</label>
            <input type="text" class="form-control" id="faturaId" placeholder="Digite o ID da fatura">
          </div>
          <div class="mb-3">
            <label for="valorPagamento" class="form-label">Valor</label>
            <input type="number" class="form-control" id="valorPagamento" placeholder="Valor a pagar">
          </div>
          <button type="submit" class="btn ">Realizar Pagamento</button>
        </form>
      </div>

      <!-- Dashboard Financeiro com Gráfico de Pizza -->
     <!-- Dashboard Financeiro com Gráfico de Pizza -->
<div class="mb-5">
    <h2>Dashboard Financeiro</h2>
    <div style="position: relative; height: 300px; width: 100%;">
      <canvas id="financeChart"></canvas>
    </div>
  </div>
  
      <!-- Histórico de Boletos Pagos -->
      <div class="card mb-5">
        <div class="card-header">
          Histórico de Boletos Pagos
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Data de Pagamento</th>
                <th>Número do Boleto</th>
                <th>Valor</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>01/03/2025</td>
                <td>#1234</td>
                <td>R$ -150,00</td>
                <td>Pago</td>
              </tr>
              <tr>
                <td>25/02/2025</td>
                <td>#1233</td>
                <td>R$ -100,00</td>
                <td>Pago</td>
              </tr>
              <!-- Outras linhas de boletos pagos -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Rodapé (reutilize o mesmo) -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 text-center text-lg-start my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item"><a href="#!">About</a></li>
              <li class="list-inline-item">⋅</li>
              <li class="list-inline-item"><a href="#!">Contact</a></li>
              <!-- outros itens -->
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">&copy; Point Network 2025. All Rights Reserved.</p>
          </div>
          <div class="col-lg-6 text-center text-lg-end my-auto">
            <ul class="list-inline mb-0">
              <li class="list-inline-item me-4">
                <a href="https://www.facebook.com/pointcondominio"><i class="bi-facebook fs-3"></i></a>
              </li>
              <!-- outros ícones -->
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('financeChart').getContext('2d');
const financeChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
    datasets: [{
      label: 'Pagamentos (R$)',
      data: [150, 200, 180, 220, 170, 250],
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
    maintainAspectRatio: false, // teste removendo ou definindo true se necessário
  }
});

    </script>
  </body>
</html>
