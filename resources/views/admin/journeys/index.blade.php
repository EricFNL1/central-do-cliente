<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Gerenciar Jornada</title>
</head>
<body>
    <h1>Jornada do Aprendizado</h1>

    @if(session('status'))
      <p style="color: green;">{{ session('status') }}</p>
    @endif

    <p><a href="{{ route('admin.journeys.create') }}">Novo Card</a></p>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($journeys as $journey)
            <tr>
                <td>{{ $journey->id }}</td>
                <td>{{ $journey->title }}</td>
                <td>
                    <a href="{{ route('admin.journeys.edit', $journey->id) }}">Editar</a>
                    |
                    <form action="{{ route('admin.journeys.destroy', $journey->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Nenhum card cadastrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
