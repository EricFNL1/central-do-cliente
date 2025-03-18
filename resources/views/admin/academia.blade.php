<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Treinamentos (Admin)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f5f5f5; }
        form { margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        .success { color: green; margin: 10px 0; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Gerenciar Treinamentos (Admin)</h1>

    
    <!-- Exibe mensagem de sucesso, se houver -->
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <!-- Exibe erros de validação, se houver -->
    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Formulário para Criar ou Editar -->
    <!-- Formulário para Criação ou Edição -->
@if(isset($treinamento))
    <!-- Modo Edição -->
    <h2>Editar Treinamento</h2>
    <form action="{{ route('admin.academia.update', $treinamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Título:
            <input type="text" name="titulo" value="{{ old('titulo', $treinamento->titulo) }}" required>
        </label>
        <label>Descrição:
            <textarea name="descricao" required>{{ old('descricao', $treinamento->descricao) }}</textarea>
        </label>
        <label>Link:
            <input type="url" name="link" value="{{ old('link', $treinamento->link) }}">
        </label>
        <label>Categoria:
            <select name="categoria_id" required>
                <option value="">Selecione uma categoria</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ (isset($treinamento) && $treinamento->categoria_id == $categoria->id) ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </label>
        <button type="submit">Atualizar</button>
        <a href="{{ route('admin.academia.index') }}">Cancelar Edição</a>
    </form>
@else
    <!-- Modo Criação -->
    <h2>Novo Treinamento</h2>
    <form action="{{ route('admin.academia.store') }}" method="POST">
        @csrf
        <label>Título:
            <input type="text" name="titulo" value="{{ old('titulo') }}" required>
        </label>
        <label>Descrição:
            <textarea name="descricao" required>{{ old('descricao') }}</textarea>
        </label>
        <label>Link:
            <input type="url" name="link" value="{{ old('link') }}">
        </label>
        <a href="{{route('admin.categorias.create')}}">Criar categoria</a>
        <label for="categoria_id">Categoria:</label>
<select name="categoria_id" id="categoria_id" required>
  <option value="">Selecione</option>
  @foreach($categorias as $cat)
    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
  @endforeach
</select>

        </label>
        <button type="submit">Cadastrar</button>
    </form>
@endif


    <!-- Tabela de Listagem -->
    <h2>Lista de Treinamentos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descrição</th>
                <th>Link</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($treinamentos as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->titulo }}</td>
                    <td>{{ $t->descricao }}</td>
                    <td>
                        @if($t->link)
                            <a href="{{ $t->link }}" target="_blank">Acessar</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <!-- Botão de Editar -->
                        <a href="{{ route('admin.academia.edit', $t->id) }}">Editar</a>

                        <!-- Form de Excluir -->
                        <form action="{{ route('admin.academia.destroy', $t->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Deseja excluir este treinamento?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum treinamento cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
