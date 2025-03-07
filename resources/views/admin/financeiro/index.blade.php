<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Admin - Gerenciar Faturas</title>
</head>
<body>
    <h1>Gerenciar Faturas</h1>

    @if(session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <p><a href="{{ route('admin.financeiro.create') }}">Nova Fatura</a></p>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Administradora</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Emissão</th>
                <th>Vencimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faturas as $fatura)
            <tr>
                <td>{{ $fatura->id }}</td>
                <!-- Exibe o nome da administradora, ou 'N/A' se não existir -->
                <td>{{ optional($fatura->administradora)->nome ?? 'N/A' }}</td>
                
                <td>{{ $fatura->descricao }}</td>
                <td>R$ {{ number_format($fatura->valor, 2, ',', '.') }}</td>
                <td>{{ $fatura->status }}</td>
                <td>{{ $fatura->data_emissao->format('d/m/Y') }}</td>
                <td>{{ $fatura->data_vencimento->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.financeiro.edit', $fatura->id) }}">Editar</a> |
                    <form action="{{ route('admin.financeiro.destroy', $fatura->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Nenhuma fatura cadastrada.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
