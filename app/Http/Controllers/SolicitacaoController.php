<?php

namespace App\Http\Controllers;

use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SolicitacaoController extends Controller
{
    /**
     * Lista todas as solicitações do usuário logado.
     */
    public function index()
    {
        // Se quiser filtrar por admin, faça uma verificação se (Auth::user()->categoria === 'admin')...
        // Mas aqui, listaremos somente as solicitações do próprio usuário.
        $solicitacoes = Solicitacao::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('solicitacoes.index', compact('solicitacoes'));
    }

    /**
     * Exibe o formulário de criação de nova solicitação.
     */
    public function create()
    {
        return view('solicitacoes.create');
    }

    /**
     * Salva a nova solicitação no banco.
     */
    public function store(Request $request)
    {
        // Validação simples
        $request->validate([
            'assunto'   => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria' => 'required|string|in:financeiro,tecnico,geral',
            'anexo'     => 'nullable|file|max:2048', // 2MB, ajuste conforme necessidade
        ]);

        // Lida com upload de anexo (se existir)
        $caminhoAnexo = null;
        if ($request->hasFile('anexo')) {
            // Salva em storage/app/public/solicitacoes
            $caminhoAnexo = $request->file('anexo')->store('solicitacoes', 'public');
        }

        // Cria a solicitação
        Solicitacao::create([
            'user_id'   => Auth::id(),
            'assunto'   => $request->assunto,
            'descricao' => $request->descricao,
            'categoria' => $request->categoria,
            'status'    => 'aberto', // default
            'anexo'     => $caminhoAnexo,
        ]);

        return redirect()->route('solicitacoes.index')
            ->with('status', 'Solicitação criada com sucesso!');
    }

    /**
     * Exibe detalhes de uma solicitação (opcional).
     */
    public function show(Solicitacao $solicitacao)
    {
        // Garante que só o dono (ou admin) possa ver
        if ($solicitacao->user_id !== Auth::id() && Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        return view('solicitacoes.show', compact('solicitacao'));
    }

    // Métodos edit, update, destroy podem ser criados se necessário
}
