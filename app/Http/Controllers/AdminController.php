<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Verifica se o usuário é admin antes de qualquer método
        $this->middleware(function ($request, $next) {
            if (Auth::user()->categoria !== 'admin') {
                abort(403, 'Acesso não autorizado');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Exemplo de exibição de painel
        return view('admin.panel');
    }

    // Outros métodos de administração...
}
