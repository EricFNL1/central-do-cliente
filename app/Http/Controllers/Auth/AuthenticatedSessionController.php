<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
// Importe seu model de log, por exemplo:
use App\Models\AccessLog;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe a tela de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Processa o login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentica o usuário
        $request->authenticate();

        // Regenera a sessão para evitar fixação de sessão
        $request->session()->regenerate();

        // Salva o log de acesso
        AccessLog::create([
            'user_id'    => Auth::id(),
            'accessed_at'=> Carbon::now(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        // Redireciona para a rota de destino após login
        return redirect()->intended(route('index'));
    }

    /**
     * Destrói a sessão autenticada (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
