<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Novo Cadastro de Categoria</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Inclua outros estilos se necessário -->
</head>
<body>
  <div class="container">
    <h1>Nova Categoria</h1>
    <!-- Mensagem de sucesso -->
    @if(session('success'))
      <div style="color: green;">{{ session('success') }}</div>
    @endif

    <!-- Exibição de erros -->
    @if($errors->any())
      <div style="color: red;">
        <ul>
          @foreach($errors->all() as $error)
             <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <label for="nome">Nome da Categoria:</label>
      <input type="text" name="nome" id="nome" required>
      <br><br>
      <label for="imagem">Imagem (opcional):</label>
      <input type="file" name="imagem" id="imagem">
      <br><br>
      <button type="submit">Cadastrar Categoria</button>
    </form>
  </div>
</body>
</html>
