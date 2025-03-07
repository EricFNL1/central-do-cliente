<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Fatura;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index()
    {
        // Obtém a administradora do usuário logado
        $administradoraId = Auth::user()->administradora_id;

        // Lista todas as faturas dessa administradora, ordenadas por data_vencimento
        $faturas = Fatura::where('administradora_id', $administradoraId)
                         ->orderBy('data_vencimento', 'asc')
                         ->get();

        // Valor em Aberto: soma das faturas pendentes
        $valorEmAberto = Fatura::where('administradora_id', $administradoraId)
                               ->where('status', 'pendente')
                               ->sum('valor');

        // Faturas Pendentes: contagem de faturas pendentes
        $faturasPendentes = Fatura::where('administradora_id', $administradoraId)
                                  ->where('status', 'pendente')
                                  ->count();

        // Últimas Transações: últimas 3 faturas atualizadas (ou pagas)
        $ultimasTransacoes = Fatura::where('administradora_id', $administradoraId)
                                   ->orderBy('updated_at', 'desc')
                                   ->take(3)
                                   ->get();

        // Histórico: todas as faturas, ordenadas por data_vencimento (desc)
        $historico = Fatura::where('administradora_id', $administradoraId)
                           ->orderBy('data_vencimento', 'desc')
                           ->get();

        // Exemplo de gerar dados do gráfico dinamicamente (faturas pagas por mês no ano atual)
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
        // Mapeamento de número do mês para nome
        $mesNomes = [
            1=>'Jan', 2=>'Fev', 3=>'Mar', 4=>'Abr',
            5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Ago',
            9=>'Set', 10=>'Out', 11=>'Nov', 12=>'Dez'
        ];

        // Inicializa array de 12 meses com zero
        $meses = array_fill_keys(array_values($mesNomes), 0);

        // Pega faturas pagas este ano
        $faturasPagas = Fatura::where('administradora_id', $admId)
                              ->where('status','pago')
                              ->whereYear('data_pagamento', date('Y'))
                              ->get();

        foreach ($faturasPagas as $f) {
            if (!$f->data_pagamento) {
                continue; // Se não tiver data_pagamento, pula
            }

            // Número do mês (1..12)
            $numMes = $f->data_pagamento->format('n');
            // Nome do mês (ex.: "Jan")
            $mesNome = $mesNomes[$numMes];
            // Soma o valor no array
            $meses[$mesNome] += $f->valor;
        }

        // Monta arrays para labels e data
        $labels = array_keys($meses);   // ['Jan','Fev','Mar',...]
        $data   = array_values($meses); // [150, 200, 0, ...]

        return [
            'labels' => $labels,
            'data'   => $data,
        ];
    }

    public function pagarFatura(Request $request)
    {
        $request->validate([
            'fatura_id' => 'required', // ajuste conforme sua lógica
            'valor'     => 'required|numeric|min:0.01',
        ]);

        // Localiza a fatura
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
