<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Lista de Usuários</title>
</head>
<body>
    <h1>Lista de Usuários</h1>

    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Categoria</th>
                <th>Administradora</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->categoria }}</td>
                    <td>
                        {{ $user->administradora 
                           ? $user->administradora->nome 
                           : 'N/A' }}
                    </td>
                    <td>
                        <!-- Exemplo de link de edição (se implementado) -->
                        <a href="{{ route('admin.usuarios.edit', $user->id) }}">
                            Editar
                        </a>
                        |
                        <!-- Form de exclusão (se implementado) -->
                        <form action="{{ route('admin.usuarios.destroy', $user->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhum usuário cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('admin.usuarios.create') }}">Cadastrar Novo Usuário</a></p>
    <p><a href="{{ route('admin.panel') }}">Voltar ao Painel Admin</a></p>
</body>
</html>
