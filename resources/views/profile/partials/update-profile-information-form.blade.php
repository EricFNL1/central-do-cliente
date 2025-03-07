<section class="mb-5">
  <h2 class="mb-3">Informações do Perfil</h2>
  <p class="text-muted">
    Atualize o nome e email da sua conta. Se o seu email não estiver verificado, 
    você pode reenviar o link de verificação.
  </p>

  <!-- Form para reenviar verificação (oculto, mas acessível via botão) -->
  <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <!-- Nome -->
    <div class="mb-3">
      <label for="name" class="form-label">Nome</label>
      <input 
        type="text" 
        class="form-control @error('name') is-invalid @enderror" 
        id="name" 
        name="name" 
        value="{{ old('name', $user->name) }}" 
        required 
        autofocus 
        autocomplete="name"
      />
      @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input 
        type="email" 
        class="form-control @error('email') is-invalid @enderror" 
        id="email" 
        name="email" 
        value="{{ old('email', $user->email) }}" 
        required 
        autocomplete="username"
      />
      @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror

      <!-- Verificação de email (se MustVerifyEmail e não verificado) -->
      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
          <p class="text-muted small mb-2">
            Seu endereço de email não está verificado.
            <button 
              form="send-verification"
              class="btn btn-link p-0 align-baseline"
            >
              Reenviar link de verificação
            </button>
          </p>
          @if (session('status') === 'verification-link-sent')
            <p class="text-success small mb-0">
              Um novo link de verificação foi enviado para seu email.
            </p>
          @endif
        </div>
      @endif
    </div>

    <!-- Botão Salvar e mensagem de sucesso -->
    <div class="d-flex align-items-center gap-3">
      <button type="submit" class="btn">
        Salvar
      </button>
      
      @if (session('status') === 'profile-updated')
        <p 
          x-data="{ show: true }"
          x-show="show"
          x-transition
          x-init="setTimeout(() => show = false, 2000)"
          class="text-success small mb-0"
        >
          Alterações salvas com sucesso!
        </p>
      @endif
    </div>
  </form>
</section>
