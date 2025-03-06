<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validação: Se o usuário que está sendo cadastrado não for admin, a administradora é obrigatória.
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    
        // Se o campo 'categoria' não for admin, exija administradora_id
        if ($request->categoria !== 'admin') {
            $rules['administradora_id'] = 'required|exists:administradoras,id';
        }
    
        $validatedData = $request->validate($rules);
    
        // Para admin, se desejar, pode permitir que administradora_id seja null.
        $user = User::create([
            'name'              => $validatedData['name'],
            'email'             => $validatedData['email'],
            'password'          => bcrypt($validatedData['password']),
            'categoria'         => $request->categoria,  // Deve vir do formulário ou forçado a 'user'
            'administradora_id' => $request->categoria !== 'admin' ? $validatedData['administradora_id'] : null,
        ]);
    
        return redirect()->route('admin.panel')->with('status', 'Usuário cadastrado com sucesso!');
    }
    public function index()
    {
        if (auth()->user()->categoria === 'admin') {
            // Admin: acesso a todos os registros
            $users = User::all();
        } else {
            // Usuário comum: somente os usuários da sua administradora
            $users = User::where('administradora_id', auth()->user()->administradora_id)->get();
        }
        
        return view('admin.usuarios.index', compact('users'));
    }
    public function edit(User $user)
    {
        // Se o usuário logado não for admin, certifique-se que ele só pode editar usuários da mesma administradora
        if (auth()->user()->categoria !== 'admin' && auth()->user()->administradora_id !== $user->administradora_id) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Retorne a view de edição com os dados do usuário
        // Supondo que você tenha uma view em resources/views/admin/usuarios/edit.blade.php
        return view('admin.usuarios.edit', compact('user'));
    }
            
    
}
