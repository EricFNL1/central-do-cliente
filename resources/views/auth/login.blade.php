<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Login - PointCondominio</title>
  <!-- Responsividade -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Google Font (opcional) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <!-- Ícones (opcional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Estilos customizados -->
  <style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Inter', sans-serif;
    }
    /* Container principal que ocupará toda a tela */
    .login-wrapper {
      display: flex;
      min-height: 100vh; /* ocupa toda a altura da tela */
      background: url('img/banner-login.png') no-repeat center center;
      background-size: cover;
    }

    /* Área de texto de boas-vindas */
    .welcome-text {
      flex: 1; /* Ocupa o espaço restante à esquerda */
      display: flex;
      flex-direction: column;
      justify-content: center; /* centraliza verticalmente */
      margin-left: 5%;
      color: #fff;
      max-width: 45%; /* limite de largura do texto */
    }
    .welcome-text h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 1rem;
    }
    .welcome-text p {
      font-size: 1rem;
      line-height: 1.4;
    }

    /* Área do formulário de login (cartão) */
    .login-area {
      width: 100%;
      max-width: 400px; /* Largura máxima do form */
      background-color: #fff;
      margin: 10rem; /* espaço entre borda e cartão */
      border-radius: 8px;
      padding: 2rem;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      align-self: center; /* centraliza verticalmente dentro do wrapper */
    }
    .login-area h3 {
      margin-bottom: 1.5rem;
      font-weight: 600;
      text-align: center;
    }
    .login-area .form-label {
      font-weight: 500;
    }
    .btn-login {
      background-color: #6f86d6; /* roxo/azul */
      border: none;
      color: #fff;
      font-weight: 500;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    .btn-login:hover {
      background-color: #48c6ef; /* azul/verde */
    }
    .login-area a {
      text-decoration: none;
      color: #6f86d6;
    }
    .login-area a:hover {
      color: #48c6ef;
      text-decoration: underline;
    }
    .create-account {
      margin-top: 1rem;
      font-size: 0.9rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <!-- Texto de boas-vindas (lado esquerdo) -->
    <div class="welcome-text">
      <h2>Bem-vindo(a) ao PointCondominio</h2>
      <p>Aqui você gerencia tudo de forma simples e segura. 
        Aproveite todos os recursos que oferecemos para tornar seu dia a dia mais prático.</p>
    </div>

    <!-- Formulário de login (lado direito) -->
    <div class="login-area">
      <h3>Acesse sua conta</h3>

      <!-- Mensagem de status -->
      @if(session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <!-- Formulário -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Campo Email -->
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input 
            type="email" 
            class="form-control @error('email') is-invalid @enderror" 
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            placeholder="Digite seu e-mail"
          />
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Campo Senha -->
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input 
            type="password" 
            class="form-control @error('password') is-invalid @enderror" 
            id="password"
            name="password"
            required
            placeholder="Digite sua senha"
          />
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Checkbox "Lembrar-me" -->
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" id="remember" name="remember" />
          <label class="form-check-label" for="remember">
            Lembrar-me
          </label>
        </div>

        <!-- Botão de Login -->
        <div class="d-grid">
          <button type="submit" class="btn btn-login">
            Entrar
          </button>
        </div>

        <!-- Link Esqueceu a senha -->
        <div class="text-end mt-2">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="small">
              Esqueceu sua senha?
            </a>
          @endif
        </div>
      </form>
    </div> <!-- .login-area -->
  </div> <!-- .login-wrapper -->

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
