<section class="mb-5">
  <header class="mb-3">
    <h2 class="h4">Atualizar Senha</h2>
    <p class="text-muted">
      Garanta que sua conta esteja usando uma senha longa e aleatória para manter a segurança.
    </p>
  </header>

  <form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <!-- Campo: Senha Atual -->
    <div class="mb-3">
      <label for="update_password_current_password" class="form-label">Senha Atual</label>
      <input type="password" id="update_password_current_password" name="current_password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
      @error('current_password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Campo: Nova Senha -->
    <div class="mb-3">
      <label for="update_password_password" class="form-label">Nova Senha</label>
      <input type="password" id="update_password_password" name="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
      @error('password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Campo: Confirmar Nova Senha -->
    <div class="mb-3">
      <label for="update_password_password_confirmation" class="form-label">Confirmar Nova Senha</label>
      <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
      @error('password_confirmation', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <!-- Botão Salvar e mensagem de sucesso -->
    <div class="d-flex align-items-center gap-3">
      <button type="submit" class="btn">Salvar</button>
      @if (session('status') === 'password-updated')
        <p 
          x-data="{ show: true }"
          x-show="show"
          x-transition
          x-init="setTimeout(() => show = false, 2000)"
          class="text-success small mb-0"
        >
          Salvo.
        </p>
      @endif
    </div>
  </form>
</section>
