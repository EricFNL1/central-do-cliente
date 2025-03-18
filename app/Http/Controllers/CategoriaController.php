<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Exibe o formulário de cadastro de categoria
    public function create()
    {
        return view('admin.categorias.create');
    }

    // Processa o cadastro da categoria
    public function store(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'nome' => 'required|max:255',
            'imagem' => 'nullable|image|max:2048', // Verifica se é uma imagem e limita o tamanho (2MB, por exemplo)
        ]);

        // Se uma imagem for enviada, armazene-a e guarde o caminho
        if ($request->hasFile('imagem')) {
            // Armazena a imagem na pasta "storage/app/public/categorias" e retorna o caminho
            $imagePath = $request->file('imagem')->store('categorias', 'public');
        } else {
            $imagePath = null;
        }

        // Cria a categoria com os dados do formulário
        Categoria::create([
            'nome' => $request->nome,
            'imagem' => $imagePath,
        ]);

        // Redireciona de volta para o formulário com uma mensagem de sucesso
        return redirect()->route('admin.categorias.create')
                         ->with('success', 'Categoria cadastrada com sucesso!');
    }
}
