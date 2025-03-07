<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;
use App\Models\User;
use App\Models\Administradora;

class AdminFinanceiroController extends Controller
{
    public function index()
    {
        // Lista todas as faturas com relacionamento com a administradora
        $faturas = Fatura::with('administradora')
                    ->orderBy('data_emissao', 'desc')
                    ->get();
                    
        return view('admin.financeiro.index', compact('faturas'));
    }

    public function create()
    {
        // Carrega todas as administradoras para que o admin possa escolher
        $administradoras = Administradora::all();
    
        return view('admin.financeiro.create', compact('administradoras'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'administradora_id' => 'required|exists:administradoras,id',
            'descricao'         => 'required|string|max:255',
            'valor'             => 'required|numeric|min:0.01',
            'data_emissao'      => 'required|date',
            'data_vencimento'   => 'required|date|after_or_equal:data_emissao',
            'status'            => 'required|in:pendente,pago,cancelado',
        ]);

        Fatura::create([
            'administradora_id' => $request->administradora_id,
            'descricao'         => $request->descricao,
            'valor'             => $request->valor,
            'data_emissao'      => $request->data_emissao,
            'data_vencimento'   => $request->data_vencimento,
            'status'            => $request->status,
        ]);

        return redirect()->route('admin.financeiro.index')
            ->with('status','Fatura lançada com sucesso!');
    }

    public function edit(Fatura $fatura)
    {
        // Antes: carregava $usuarios
        // $usuarios = User::all();
    
        // Agora, se você quer reatribuir a administradora, carregue $administradoras:
        $administradoras = \App\Models\Administradora::all();
    
        return view('admin.financeiro.edit', compact('fatura', 'administradoras'));
    }
    

    public function update(Request $request, Fatura $fatura)
    {
        $request->validate([
            'administradora_id' => 'required|exists:administradoras,id',
            'valor'             => 'required|numeric|min:0.01',
            'descricao'         => 'required|string|max:255',
            'data_emissao'      => 'required|date',
            'data_vencimento'   => 'required|date|after_or_equal:data_emissao',
            'status'            => 'required|in:pendente,pago,cancelado',
        ]);

        $fatura->update($request->only([
            'administradora_id', 'valor', 'descricao', 'data_emissao', 'data_vencimento', 'status'
        ]));

        return redirect()->route('admin.financeiro.index')
            ->with('status','Fatura atualizada com sucesso!');
    }

    public function destroy(Fatura $fatura)
    {
        $fatura->delete();
        return redirect()->route('admin.financeiro.index')
            ->with('status','Fatura excluída com sucesso!');
    }
}
