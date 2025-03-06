<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administradora;

class AdministradoraController extends Controller
{
    public function create()
    {
        return view('admin.administradoras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            // Adicione outras validações conforme necessário
        ]);

        Administradora::create($request->all());

        return redirect()->route('admin.panel')->with('status', 'Administradora cadastrada com sucesso!');
    }
}
