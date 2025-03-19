<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Treinamento;
use App\Models\TreinamentoProgress;
use Illuminate\Support\Facades\Auth;

class AcademiaController extends Controller
{
    public function index()
    {
        // Carrega todas as categorias com os treinamentos relacionados
        $categorias = Categoria::with('treinamentos')->get();
        
        // Obtém o ID do usuário logado
        $userId = Auth::id();

        // Coleta os IDs de todos os treinamentos de todas as categorias
        $treinamentoIds = [];
        foreach ($categorias as $categoria) {
            foreach ($categoria->treinamentos as $treinamento) {
                $treinamentoIds[] = $treinamento->id;
            }
        }
        $treinamentoIds = array_unique($treinamentoIds);

        // Busca os progressos do usuário para os treinamentos carregados,
        // indexando o resultado pelo treinamento_id para facilitar o acesso na view
        $progressos = TreinamentoProgress::where('user_id', $userId)
            ->whereIn('treinamento_id', $treinamentoIds)
            ->get()
            ->keyBy('treinamento_id');

        return view('academia', compact('categorias', 'progressos'));
    }
}
