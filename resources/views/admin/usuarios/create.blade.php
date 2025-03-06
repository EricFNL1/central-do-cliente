<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <h1>Cadastrar Usuário</h1>

    <!-- Exibe erros de validação -->
    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mensagem de status (se vier do controller) -->
    @if (session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <label for="name">Nome:</label><br>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required><br><br>

        <label for="password">Senha:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirmation">Confirmar Senha:</label><br>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br><br>

        <label for="categoria">Categoria:</label><br>
        <select name="categoria" id="categoria">
            <option value="user" {{ old('categoria') === 'user' ? 'selected' : '' }}>Usuário</option>
            <option value="admin" {{ old('categoria') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <br><br>

        <label for="administradora_id">Administradora (obrigatório se categoria=usuário):</label><br>
        <select name="administradora_id" id="administradora_id">
            <option value="">-- Selecione --</option>
            @foreach(\App\Models\Administradora::all() as $adm)
                <option value="{{ $adm->id }}"
                    {{ old('administradora_id') == $adm->id ? 'selected' : '' }}>
                    {{ $adm->nome }}
                </option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <p><a href="{{ route('admin.usuarios.index') }}">Voltar à lista de usuários</a></p>
    <p><a href="{{ route('admin.panel') }}">Voltar ao Painel Admin</a></p>
</body>
</html>
