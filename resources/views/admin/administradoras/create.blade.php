<!-- resources/views/admin/administradoras/create.blade.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Adicionar Administradora</title>
</head>
<body>
    <header>
        <h1>Adicionar Administradora</h1>
    </header>

    <main>
        <!-- Exibe erros de validação, se houver -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.administradoras.store') }}" method="POST">
            @csrf
            <label for="nome">Nome da Administradora:</label>
            <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required>
            <button type="submit">Salvar</button>
        </form>

        <p><a href="{{ route('admin.panel') }}">Voltar ao Painel</a></p>
    </main>

    <footer>
        <p>&copy; 2025 - Todos os direitos reservados.</p>
    </footer>
</body>
</html>
