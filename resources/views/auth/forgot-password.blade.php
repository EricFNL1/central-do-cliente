<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Esqueceu a Senha - PointCondominio</title>
  <!-- Responsividade -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Google Font (opcional) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <!-- Ícones (opcional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Estilos customizados (se houver) -->
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Inter', sans-serif;
      /* Opcional: imagem de fundo ou cor */
      background: url('img/bg-forgot.jpg') no-repeat center center;
      background-size: cover;
    }

    /* Wrapper para centralizar o cartão vertical/horizontalmente */
    .forgot-wrapper {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }

    /* Cartão com o formulário */
    .forgot-card {
      background-color: #fff;
      border-radius: 8px;
      padding: 2rem;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .forgot-card h3 {
      font-weight: 600;
      margin-bottom: 1.5rem;
      text-align: center;
    }
    .forgot-card .btn-submit {
      background-color: #6f86d6; /* roxo/azul */
      border: none;
      color: #fff;
      font-weight: 500;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    .forgot-card .btn-submit:hover {
      background-color: #48c6ef; /* azul/verde */
    }
  </style>
</head>
<body>
  <div class="forgot-wrapper">
    <div class="forgot-card">
      <!-- Título -->
      <h3>Esqueceu sua senha?</h3>

      <!-- Mensagem explicativa -->
      <p class="text-muted">
        Esqueceu sua senha? Sem problemas. Basta informar seu endereço de e-mail e enviaremos um link para redefinir sua senha.
      </p>

      <!-- Exibição do status (ex.: se um link de redefinição foi enviado) -->
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif

      <!-- Formulário -->
      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Campo de E-mail -->
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

        <!-- Botão de Envio -->
        <div class="d-grid">
          <button type="submit" class="btn btn-submit">
            Enviar Link de Redefinição
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
