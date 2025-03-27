<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Treinamento;


class TreinamentoController extends Controller
{
    public function show(Treinamento $treinamento)
    {
        return view('treinamentos.show', compact('treinamento'));
    }

    // Exibe o formulário de edição
    public function edit(Treinamento $treinamento)
    {
        return view('treinamentos.edit', compact('treinamento'));
    }

    // Atualiza o treinamento no banco
    public function update(Request $request, Treinamento $treinamento)
    {
        $data = $request->validate([
            'titulo'   => 'required|string|max:255',
            'descricao'=> 'nullable|string',
            'conteudo' => 'nullable|string',
        ]);

        $treinamento->update($data);

        return redirect()->route('treinamentos.show', $treinamento->id)
                         ->with('success', 'Treinamento atualizado com sucesso!');
    }
}
