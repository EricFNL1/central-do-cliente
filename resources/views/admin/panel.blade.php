<!-- resources/views/admin/panel.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Painel Admin</title>
</head>
<body>
    <header>
        <h1>Painel Admin</h1>
    </header>

    <main>
        <p>Bem-vindo, {{ Auth::user()->name }}!</p>

        @if (session('status'))
            <p style="color: green;">{{ session('status') }}</p>
        @endif

        <ul>
            <li><a href="{{ route('admin.administradoras.create') }}">Adicionar Administradora</a></li>
            <li><a href="{{ route('admin.usuarios.create') }}">Cadastrar Usuário</a></li>
            <li><a href="{{ route('index') }}">Voltar</a></li>
        </ul>

        <!-- Exemplo de logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Sair</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2025 - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
