<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Logs de Acesso</title>
</head>
<body>
    <h1>Logs de Acesso</h1>

    <!-- Mensagem de status (se vier do controller) -->
    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Data/Hora</th>
                <th>IP</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>
                        @if ($log->user)
                            {{ $log->user->name }}
                        @else
                            Usuário não encontrado
                        @endif
                    </td>
                    <td>{{ $log->accessed_at }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->user_agent }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhum log encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginação (se usar paginate) -->
    @if(method_exists($logs, 'links'))
        <div style="margin-top: 1rem;">
            {{ $logs->links() }}
        </div>
    @endif

    <p><a href="{{ route('admin.panel') }}">Voltar ao Painel Admin</a></p>
</body>
</html>
