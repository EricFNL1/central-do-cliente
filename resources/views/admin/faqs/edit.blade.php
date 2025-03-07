<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar FAQ</title>
</head>
<body>
    <h1>Editar FAQ #{{ $faq->id }}</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div>
            <label for="pergunta">Pergunta:</label><br>
            <input type="text" name="pergunta" id="pergunta"
                   value="{{ old('pergunta', $faq->pergunta) }}" required>
        </div>

        <div>
            <label for="resposta">Resposta:</label><br>
            <textarea name="resposta" id="resposta" rows="5" required>{{ old('resposta', $faq->resposta) }}</textarea>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="{{ route('admin.faqs.index') }}">Voltar</a></p>
</body>
</html>
