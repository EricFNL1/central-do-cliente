<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Treinamento;

class AdminAcademiaController extends Controller
{
    /**
     * Exibe a lista de treinamentos e o formulário de cadastro
     */
    public function index()
    {
        // Buscar todos os treinamentos
        $categorias = \App\Models\Categoria::all();

        // Busca os treinamentos cadastrados
        $treinamentos = \App\Models\Treinamento::all();
    
        // Se não estiver editando, somente envia as variáveis para a view
        return view('admin.academia', compact('treinamentos', 'categorias'));
    }

    /**
     * Armazena um novo treinamento no banco
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo'       => 'required|max:255',
            'descricao'    => 'required',
            'link'         => 'nullable|url',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
    
        Treinamento::create([
            'titulo'       => $request->titulo,
            'descricao'    => $request->descricao,
            'link'         => $request->link,
            'categoria_id' => $request->categoria_id, // IMPORTANTE!
        ]);
    
        return redirect()->route('admin.academia.index')
                         ->with('success', 'Treinamento cadastrado com sucesso!');
    }
    


    /**
     * Exibe a mesma view, porém com dados para edição de um treinamento específico
     */
    public function edit($id)
    {
        // Buscar o treinamento a ser editado
        $treinamento = Treinamento::findOrFail($id);

        // Buscar todos os treinamentos para a listagem
        $treinamentos = Treinamento::all();

        // Retorna a mesma view, mas agora com a variável $treinamento definida (modo edição)
        return view('admin.academia', compact('treinamento', 'treinamentos'));
    }

    /**
     * Atualiza os dados de um treinamento existente
     */
    public function update(Request $request, $id)
    {
        // Validação
        $request->validate([
            'titulo' => 'required|max:255',
            'descricao' => 'required',
            'link' => 'nullable|url',
        ]);

        // Encontrar o registro
        $treinamento = Treinamento::findOrFail($id);

        // Atualiza com os dados do formulário
        $treinamento->update($request->all());

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('admin.academia.index')
                         ->with('success', 'Treinamento atualizado com sucesso!');
    }

    /**
     * Exclui um treinamento do banco
     */
    public function destroy($id)
    {
        $treinamento = Treinamento::findOrFail($id);
        $treinamento->delete();

        return redirect()->route('admin.academia.index')
                         ->with('success', 'Treinamento excluído com sucesso!');
    }
}
