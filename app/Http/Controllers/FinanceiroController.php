<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fatura;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index(Request $request)
    {
        $administradoraId = Auth::user()->administradora_id;

        // Valor em Aberto: soma das faturas pendentes
        $valorEmAberto = Fatura::where('administradora_id', $administradoraId)
                               ->where('status', 'pendente')
                               ->sum('valor');

        // Faturas Pendentes: contagem de faturas pendentes
        $faturasPendentes = Fatura::where('administradora_id', $administradoraId)
                                  ->where('status', 'pendente')
                                  ->count();

        // Últimas Transações (ex.: últimas 3 faturas atualizadas/pagas)
        $ultimasTransacoes = Fatura::where('administradora_id', $administradoraId)
                                   ->orderBy('updated_at', 'desc')
                                   ->take(3)
                                   ->get();

        // Histórico: todas as faturas da administradora, paginadas
        // Se quiser apenas as faturas pagas, ajuste a query
        // Exemplo: ->where('status', 'pago')
        $historico = Fatura::where('administradora_id', $administradoraId)
                           ->orderBy('data_vencimento', 'desc')
                           // usa paginação de 5 itens para o histórico
                           ->paginate(5, ['*'], 'historicoPage');

        // Faturas (por exemplo, listando todas, ou somente “todas” sem filtrar status)
        $faturas = Fatura::where('administradora_id', $administradoraId)
                         ->orderBy('data_vencimento', 'asc')
                         // usa paginação de 5 itens para a lista de faturas
                         ->paginate(5, ['*'], 'faturasPage');

        // Dados do gráfico (faturas pagas por mês)
        $chartData = $this->gerarDadosGrafico($administradoraId);

        return view('financeiro.index', [
            'valorEmAberto'    => $valorEmAberto,
            'faturasPendentes' => $faturasPendentes,
            'ultimasTransacoes'=> $ultimasTransacoes,
            'historico'        => $historico,
            'faturas'          => $faturas,
            'chartData'        => $chartData,
        ]);
    }

    /**
     * Exemplo de método para gerar dados do gráfico dinamicamente.
     * Soma as faturas pagas no ano corrente, agrupando por mês de data_pagamento.
     */
    private function gerarDadosGrafico($admId)
    {
        $mesNomes = [
            1=>'Jan', 2=>'Fev', 3=>'Mar', 4=>'Abr',
            5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Ago',
            9=>'Set', 10=>'Out', 11=>'Nov', 12=>'Dez'
        ];

        // Inicializa array de 12 meses com zero
        $meses = array_fill_keys(array_values($mesNomes), 0);

        // Faturas pagas este ano
        $faturasPagas = Fatura::where('administradora_id', $admId)
                              ->where('status','pago')
                              ->whereYear('data_pagamento', date('Y'))
                              ->get();

        foreach ($faturasPagas as $f) {
            if (!$f->data_pagamento) {
                continue;
            }

            $numMes = $f->data_pagamento->format('n'); // 1..12
            $mesNome = $mesNomes[$numMes];
            $meses[$mesNome] += $f->valor;
        }

        $labels = array_keys($meses);
        $data   = array_values($meses);

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    public function pagarFatura(Request $request)
    {
        $request->validate([
            'fatura_id' => 'required',
            'valor'     => 'required|numeric|min:0.01',
        ]);

        $fatura = Fatura::findOrFail($request->fatura_id);

        // Verifica se a fatura está pendente
        if ($fatura->status !== 'pendente') {
            return redirect()->route('financeiro')
                ->with('status', 'Fatura não está pendente para pagamento.');
        }

        // Marca como pago
        $fatura->status = 'pago';
        $fatura->data_pagamento = Carbon::now();
        $fatura->save();

        return redirect()->route('financeiro')
            ->with('status', 'Pagamento realizado com sucesso!');
    }
}
