<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademiaController extends Controller
{
    public function index()
    { // Exemplo de dados estáticos (substitua por busca no banco, se necessário)
        $treinamentos = [
            [
                'titulo' => 'Treinamento Contas',
                'descricao' => 'Aprenda os fundamentos do financeiro.',
                'link' => '#'
            ],
            [
                'titulo' => 'Treinamento Avançado de Pagamentos',
                'descricao' => 'Aprofunde seus conhecimentos em Pagamentos.',
                'link' => '#'
            ],
        ];
    
        // Retorna a view passando a variável
        return view('academia', compact('treinamentos'));  
    }
}
