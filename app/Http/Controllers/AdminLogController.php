<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AccessLog;

class AdminLogController extends Controller
{
    public function index()
    {
        // Verifica se o usuário logado é admin
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Busca todos os logs (ou utilize paginação, se preferir)
        // Carregando também o relacionamento com o usuário (se houver)
        $logs = AccessLog::with('user')
            ->orderBy('accessed_at', 'desc')
            ->paginate(20); // Exemplo: 20 por página

        // Retorna a view com os logs
        return view('admin.logs.index', compact('logs'));
    }
}
