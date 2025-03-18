<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Treinamento;

class AcademiaController extends Controller
{
 

    public function index()
    {
        // Carrega todas as categorias com os treinamentos relacionados
        $categorias = Categoria::with('treinamentos')->get();
    
        return view('academia', compact('categorias'));
    }
    
}
