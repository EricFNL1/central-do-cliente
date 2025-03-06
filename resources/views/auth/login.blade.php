<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Central do Cliente - Login" />
    <meta name="author" content="" />
    <title>Central do Cliente - Login</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="img/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (inclui Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/point.css" />
    <style>
      /* Garante que o footer fique no final da página */
      body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }
      main {
        flex: 1;
      }
      /* Estilização da seção de login */
      #login {
        padding: 150px 0;
      }
      #login .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }
      #login .card-body {
        padding: 2rem;
      }
      #login .card-title {
        font-weight: bold;
        color: #333;
      }
      #login .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg themepoint static-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="#!">
          <img src="img/Pointcentral.png" alt="Logo" width="120" />
        </a>
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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Menu de navegação -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          </ul>
          <!-- Botão de retorno -->
          <div class="d-flex">
            <a class="btn btn-secondary me-2" href="https://pointcondominio.com.br/administradora">
              <i class="bi bi-arrow-left-circle me-1"></i>Voltar para o Sistema
            </a>
          </div>
        </div>
      </div>
    </nav>

    <main>
      <!-- Seção de Login -->
      <section id="login">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title text-center mb-4">Login</h3>

                  {{-- Exibição da mensagem de sessão, se houver --}}
                  @if (session('status'))
                    <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                    </div>
                  @endif

                  <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Campo de Email -->
                    <div class="mb-3">
                      <label for="email" class="form-label">{{ __('Email') }}</label>
                      <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Digite seu email"
                      />
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <!-- Campo de Senha -->
                    <div class="mb-3">
                      <label for="password" class="form-label">{{ __('Senha') }}</label>
                      <input
                        type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Digite sua senha"
                      />
                      @error('password')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>

                    <!-- Lembrar-me -->
                    <div class="mb-3 form-check">
                      <input
                        type="checkbox"
                        class="form-check-input"
                        id="remember"
                        name="remember"
                      />
                      <label class="form-check-label" for="remember">
                        {{ __('Remember me') }}
                      </label>
                    </div>

                    <div class="d-grid">
                      <button type="submit" class="btn">
                        {{ __('Log in') }}
                      </button>
                    </div>
                  </form>
                  <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}" class="small">
                        {{ __('Esqueceu sua senha?') }}
                      </a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer (fixado no final da página) -->
    <footer class="footer bg-light">
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
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
  </body>
</html>
