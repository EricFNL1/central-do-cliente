<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Usuário</title>
</head>
<body>
    <h1>Editar Usuário</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Nome -->
        <div>
            <label for="name">Nome:</label><br>
            <input type="text" name="name" id="name"
                   value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email (CAMPO NECESSÁRIO) -->
        <div>
            <label for="email">E-mail:</label><br>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Administradora -->
        <div>
            <label for="administradora_id">Administradora:</label><br>
            <select name="administradora_id" id="administradora_id">
                @foreach($administradoras as $adm)
                    <option value="{{ $adm->id }}"
                        {{ old('administradora_id', $user->administradora_id) == $adm->id ? 'selected' : '' }}>
                        {{ $adm->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Categoria -->
        <div>
            <label for="categoria">Categoria:</label><br>
            <select name="categoria" id="categoria">
                <option value="user" {{ old('categoria', $user->categoria) == 'user' ? 'selected' : '' }}>Usuário</option>
                <option value="admin" {{ old('categoria', $user->categoria) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="{{ route('admin.usuarios.index') }}">Voltar</a></p>
</body>
</html>
