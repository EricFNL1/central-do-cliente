<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Gerenciar FAQs</title>
</head>
<body>
    <h1>Lista de FAQs</h1>

    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <p>
        <a href="{{ route('admin.faqs.create') }}">Nova FAQ</a>
    </p>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pergunta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $faq)
                <tr>
                    <td>{{ $faq->id }}</td>
                    <td>{{ $faq->pergunta }}</td>
                    <td>
                        <a href="{{ route('admin.faqs.edit', $faq->id) }}">Editar</a>
                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhuma FAQ cadastrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ route('admin.panel') }}">Voltar ao Painel Admin</a></p>
</body>
</html>
