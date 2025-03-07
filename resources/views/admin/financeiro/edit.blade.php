<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Editar Fatura</title>
</head>
<body>
    <h1>Editar Fatura #{{ $fatura->id }}</h1>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.financeiro.update', $fatura->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div>
        <label for="administradora_id">Administradora:</label><br>
<select name="administradora_id" id="administradora_id">
    @foreach($administradoras as $adm)
        <option value="{{ $adm->id }}" 
            {{ old('administradora_id', $fatura->administradora_id) == $adm->id ? 'selected' : '' }}>
            {{ $adm->nome }}
        </option>
    @endforeach
</select>
        </div>
        <div>
            <label for="descricao">Descrição:</label><br>
            <input type="text" name="descricao" id="descricao"
                   value="{{ old('descricao', $fatura->descricao) }}" required>
        </div>
        <div>
            <label for="valor">Valor:</label><br>
            <input type="number" step="0.01" name="valor" id="valor"
                   value="{{ old('valor', $fatura->valor) }}" required>
        </div>
        <div>
            <label for="data_emissao">Data de Emissão:</label><br>
            <input type="date" name="data_emissao" id="data_emissao"
                   value="{{ old('data_emissao', $fatura->data_emissao->format('Y-m-d')) }}" required>
        </div>
        <div>
            <label for="data_vencimento">Data de Vencimento:</label><br>
            <input type="date" name="data_vencimento" id="data_vencimento"
                   value="{{ old('data_vencimento', $fatura->data_vencimento->format('Y-m-d')) }}" required>
        </div>
        <div>
            <label for="status">Status:</label><br>
            <select name="status" id="status">
                <option value="pendente" {{ old('status', $fatura->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="pago" {{ old('status', $fatura->status) == 'pago' ? 'selected' : '' }}>Pago</option>
                <option value="cancelado" {{ old('status', $fatura->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="{{ route('admin.financeiro.index') }}">Voltar</a></p>
</body>
</html>
