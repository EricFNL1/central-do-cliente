<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\User;
use Illuminate\Http\Request;

class AdminFinanceiroController extends Controller
{
    
    public function index()
    {
        // Lista todas as faturas (ou filtra por status)
        $faturas = Fatura::with('user')->orderBy('data_emissao','desc')->get();
        return view('admin.financeiro.index', compact('faturas'));
    }

    public function create()
    {
        // Supondo que você tenha um Model `Administradora`
        $administradoras = \App\Models\Administradora::all();
    
        return view('admin.financeiro.create', compact('administradoras'));
    }
    

    public function store(Request $request)
{
    $request->validate([
        'administradora_id' => 'required|exists:administradoras,id',
        'descricao'         => 'required|string|max:255',
        'valor'            => 'required|numeric|min:0.01',
        'data_emissao'     => 'required|date',
        'data_vencimento'  => 'required|date|after_or_equal:data_emissao',
        'status'           => 'required|in:pendente,pago,cancelado',
    ]);

    \App\Models\Fatura::create([
        'administradora_id' => $request->administradora_id,
        'descricao'         => $request->descricao,
        'valor'            => $request->valor,
        'data_emissao'     => $request->data_emissao,
        'data_vencimento'  => $request->data_vencimento,
        'status'           => $request->status,
    ]);

    return redirect()->route('admin.financeiro.index')
        ->with('status','Fatura lançada com sucesso!');
}

    public function edit(Fatura $fatura)
    {
        // Lista de usuários para reatribuir, se necessário
        $usuarios = User::all();
        return view('admin.financeiro.edit', compact('fatura','usuarios'));
    }

    public function update(Request $request, Fatura $fatura)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'valor'          => 'required|numeric|min:0.01',
            'descricao'      => 'required|string|max:255',
            'data_emissao'   => 'required|date',
            'data_vencimento'=> 'required|date|after_or_equal:data_emissao',
            'status'         => 'required|in:pendente,pago,cancelado',
        ]);

        $fatura->update($request->all());

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
