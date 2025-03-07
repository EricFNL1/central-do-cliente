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
            <li><a href="{{ route('admin.logs.index') }}">Logs de Usuários</a></li>
            <li><a href="{{ route('admin.solicitacoes.index') }}">Gerenciar Solicitações</a></li>
            <li><a href="{{ route('admin.journeys.index') }}">Gerenciar Jornada</a></li>
            <li><a href="{{ route('admin.faqs.index') }}">Gerenciar FAQs</a></li>

            <!-- Novo link para a parte Financeira do Admin -->
            <li><a href="{{ route('admin.financeiro.index') }}">Financeiro (Admin)</a></li>

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
