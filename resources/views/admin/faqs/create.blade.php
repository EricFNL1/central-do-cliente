<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Cadastrar FAQ</title>
</head>
<body>
    <h1>Cadastrar FAQ</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf

        <div>
            <label for="pergunta">Pergunta:</label><br>
            <input type="text" name="pergunta" id="pergunta" value="{{ old('pergunta') }}" required>
        </div>

        <div>
            <label for="resposta">Resposta:</label><br>
            <textarea name="resposta" id="resposta" rows="5" required>{{ old('resposta') }}</textarea>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="{{ route('admin.faqs.index') }}">Voltar</a></p>
</body>
</html>
