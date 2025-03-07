<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />

  <!-- Seus estilos customizados -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/point.css') }}">

  <!-- (Opcional) Se você ainda precisar de algum script JS local -->
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</head>
<body class="d-flex flex-column min-vh-100">

  <!-- Inclui a navegação (navbar) -->
  @include('layouts.navigation') 
  {{-- Ajuste se quiser inserir a navbar manualmente --}}

  <!-- Page Heading (opcional) -->
  @isset($header)
    <header class="bg-light shadow-sm">
      <div class="container py-4">
        {{ $header }}
      </div>
    </header>
  @endisset

  <!-- Page Content -->
  <main class="flex-grow-1 my-4">
    <div class="container">
      {{ $slot }}
    </div>
  </main>

  <!-- Footer (Opcional) -->
  <footer class="footer bg-light mt-auto">
    <div class="container py-3">
      <p class="text-center text-muted small mb-0">&copy; 2025 - Point Network. Todos os direitos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap core JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
