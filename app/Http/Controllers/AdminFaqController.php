<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminFaqController extends Controller
{
    public function index()
    {
        // Lista todas as FAQs
        $faqs = Faq::orderBy('created_at', 'desc')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        // Exibe formulário de criação
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        // Valida e salva
        $request->validate([
            'pergunta' => 'required|string|max:255',
            'resposta' => 'required|string',
        ]);

        Faq::create([
            'pergunta' => $request->pergunta,
            'resposta' => $request->resposta,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('status', 'FAQ criada com sucesso!');
    }

    public function edit(Faq $faq)
    {
        // Formulário de edição
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        // Valida e atualiza
        $request->validate([
            'pergunta' => 'required|string|max:255',
            'resposta' => 'required|string',
        ]);

        $faq->update([
            'pergunta' => $request->pergunta,
            'resposta' => $request->resposta,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('status', 'FAQ atualizada com sucesso!');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')
            ->with('status', 'FAQ removida com sucesso!');
    }
}
