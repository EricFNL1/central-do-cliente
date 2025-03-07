<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Editar Card</title>
</head>
<body>
  <h1>Editar Card #{{ $journey->id }}</h1>

  @if($errors->any())
    <div style="color: red;">
      <ul>
        @foreach($errors->all() as $erro)
          <li>{{ $erro }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.journeys.update', $journey->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
      <label for="title">Título:</label><br>
      <input type="text" name="title" id="title"
             value="{{ old('title', $journey->title) }}" required>
    </div>
    <div>
  <label for="order">Ordem de Exibição:</label><br>
  <input type="number" name="order" id="order"
         value="{{ old('order', $journey->order) }}">
</div>
    <div>
      <label for="description">Descrição:</label><br>
      <textarea name="description" id="description" rows="4" required>{{ old('description', $journey->description) }}</textarea>
    </div>
    <div>
      <label for="link">Link (opcional):</label><br>
      <input type="url" name="link" id="link"
             value="{{ old('link', $journey->link) }}">
    </div>

    <button type="submit">Salvar</button>
  </form>

  <p><a href="{{ route('admin.journeys.index') }}">Voltar</a></p>
</body>
</html>
