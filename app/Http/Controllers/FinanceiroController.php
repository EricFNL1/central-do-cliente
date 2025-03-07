<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fatura;

class FinanceiroController extends Controller
{
    public function index()
    {
        // Pega a administradora do usuário logado
        $administradoraId = Auth::user()->administradora_id;

        // Lista todas as faturas dessa administradora
        // (Assim, todos os usuários/admin dessa administradora veem as mesmas faturas)
        $faturas = Fatura::where('administradora_id', $administradoraId)
                         ->orderBy('data_vencimento', 'asc')
                         ->get();

        // Valor em Aberto = soma das faturas com status "pendente" dessa administradora
        $valorEmAberto = Fatura::where('administradora_id', $administradoraId)
                               ->where('status', 'pendente')
                               ->sum('valor');

        // Faturas Pendentes = contagem de faturas com status "pendente"
        $faturasPendentes = Fatura::where('administradora_id', $administradoraId)
                                  ->where('status', 'pendente')
                                  ->count();

        // Últimas Transações (exemplo):
        // Aqui, estamos usando as últimas faturas atualizadas como “transações”.
        $ultimasTransacoes = Fatura::where('administradora_id', $administradoraId)
                                   ->orderBy('updated_at', 'desc')
                                   ->take(3)
                                   ->get();

        // Histórico (exemplo):
        // Listamos todas as faturas ordenadas por data de vencimento
        $historico = Fatura::where('administradora_id', $administradoraId)
                           ->orderBy('data_vencimento', 'desc')
                           ->get();

        // Exemplo simples de dados para o gráfico
        $chartData = [
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
            'data'   => [150, 200, 180, 220, 170, 250],
        ];

        // Retorna a view com as variáveis necessárias
        return view('financeiro.index', [
            'valorEmAberto'    => $valorEmAberto,
            'faturasPendentes' => $faturasPendentes,
            'ultimasTransacoes'=> $ultimasTransacoes,
            'historico'        => $historico,
            'faturas'          => $faturas,
            'chartData'        => $chartData,
        ]);
    }

    public function pagarFatura(Request $request)
    {
        $request->validate([
            'fatura_id' => 'required', // Ajuste conforme sua lógica
            'valor'     => 'required|numeric|min:0.01',
        ]);

        // Lógica para processar o pagamento:
        // 1. Localizar a fatura
        // 2. Verificar se está pendente
        // 3. Atualizar status para "pago", definir data_pagamento, etc.

        return redirect()->route('financeiro')->with('status', 'Pagamento realizado com sucesso!');
    }
}
