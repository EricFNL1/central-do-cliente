<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSolicitacaoController extends Controller
{
    /**
     * Lista todas as solicitações de todos os usuários.
     */
    public function index()
    {
        // Verifica se o user é admin (se não estiver usando middleware)
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Carrega as solicitações com informações de user e administradora
        $solicitacoes = Solicitacao::with(['user.administradora'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.solicitacoes.index', compact('solicitacoes'));
    }

    /**
     * Mostra detalhes de uma solicitação específica.
     */
    public function show(Solicitacao $solicitacao)
    {
        // Verifica se o user é admin
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Carrega relacionamento do usuário
        $solicitacao->load('user.administradora');

        return view('admin.solicitacoes.show', compact('solicitacao'));
    }

    /**
     * Exibe formulário para despachar solicitação (ex: atribuir a um funcionário).
     */
    public function editDespacho(Solicitacao $solicitacao)
    {
        // Verifica se o user logado é admin (se não estiver usando middleware)
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }
    
        // Busca todos os usuários com categoria 'admin'
        $admins = User::where('categoria', 'admin')->get();
    
        return view('admin.solicitacoes.despacho', [
            'solicitacao' => $solicitacao,
            'admins' => $admins,
        ]);
    }
    
    /**
     * Atualiza a solicitação (despacho ou status).
     */
    public function update(Request $request, Solicitacao $solicitacao)
    {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Exemplo de validação
        $validated = $request->validate([
            'status' => 'required|in:aberto,em-andamento,fechado',
            'funcionario_id' => 'nullable|exists:users,id', // se quiser atribuir a um user
        ]);

        // Se quiser armazenar a quem foi atribuída
        // você poderia ter uma coluna ex: "atendido_por" em solicitacoes
        if ($request->filled('funcionario_id')) {
            $solicitacao->atendido_por = $request->funcionario_id;
        }

        $solicitacao->status = $request->status;
        $solicitacao->save();

        return redirect()
            ->route('admin.solicitacoes.index')
            ->with('status', 'Solicitação atualizada com sucesso!');
    }
}
