<section class="mb-5">
  <header class="mb-3">
    <h2 class="h4">Deletar Conta</h2>
    <p class="text-muted">
      Ao deletar sua conta, todos os seus recursos e dados serão permanentemente removidos. 
      Antes de deletar, por favor, faça o download de qualquer informação que deseja reter.
    </p>
  </header>

  <!-- Botão para abrir o modal de confirmação -->
  <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#confirmDeletionModal">
    Deletar Conta
  </button>

  <!-- Modal de Confirmação -->
  <div class="modal fade" id="confirmDeletionModal" tabindex="-1" aria-labelledby="confirmDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{ route('profile.destroy') }}">
          @csrf
          @method('delete')
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeletionModalLabel">Confirmar Exclusão da Conta</h5>
            <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <p class="text-muted">
              Tem certeza de que deseja deletar sua conta? Todos os seus recursos e dados serão permanentemente removidos. 
              Por favor, insira sua senha para confirmar.
            </p>
            <div class="mb-3">
              <label for="password" class="form-label">Senha</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite sua senha" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn">Deletar Conta</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
