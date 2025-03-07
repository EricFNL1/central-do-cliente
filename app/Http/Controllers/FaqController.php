<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function search(Request $request)
    {
        // Captura o termo de pesquisa
        $query = $request->input('query');

        // Se não tiver nada digitado, redireciona de volta ou retorna vazio
        if (!$query) {
            return redirect()->back()->with('status', 'Digite algo para pesquisar');
        }

        // Busca FAQs onde a pergunta ou a resposta contenham o termo
        $faqs = Faq::where('pergunta', 'like', '%'.$query.'%')
                    ->orWhere('resposta', 'like', '%'.$query.'%')
                    ->get();

        // Retorna uma view com os resultados
        return view('faqs.search-results', compact('faqs', 'query'));
    }
}
