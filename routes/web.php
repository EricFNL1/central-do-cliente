<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministradoraController;
use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Administradora;
use App\Models\User;
use App\Http\Controllers\SolicitacaoController;
use App\Http\Controllers\AdminSolicitacaoController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdminJourneyController;
use App\Http\Controllers\FinanceiroController;
use App\Http\Controllers\AdminFinanceiroController;




// Rota raiz que exibe a tela de login (para usuários não autenticados)
Route::get('/', function () {
    // Se preferir, você pode redirecionar para '/login' se o pacote de autenticação já fornecer essa rota
    return view('auth.login');
})->middleware('guest')->name('login');

// Rota para a página de índice, que será a página inicial após o login
Route::get('/index', function () {
    return view('index'); // Crie uma view "index" com o conteúdo desejado
})->middleware(['auth', 'verified'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard'); // Crie uma view "index" com o conteúdo desejado
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/financeiro', function () {
    return view('financeiro'); // Crie uma view "index" com o conteúdo desejado
})->middleware(['auth', 'verified'])->name('financeiro');

Route::get('/solicitacao', function () {
    return view('solicitacao'); // Crie uma view "index" com o conteúdo desejado
})->middleware(['auth', 'verified'])->name('solicitacao');

Route::get('/nova', function () {
    return view('nova'); // Crie uma view "index" com o conteúdo desejado
})->middleware(['auth', 'verified'])->name('nova');



// Agrupa todas as rotas em /admin, exige que o usuário esteja logado.
Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Página principal do Admin
    Route::get('/', function () {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.panel');
    })->name('admin.panel');

    // Página para criar Administradora (formulário)
    Route::get('/administradoras/create', function () {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.administradoras.create');
    })->name('admin.administradoras.create');

    // Recebe os dados do formulário de Administradora e salva
    Route::post('/administradoras', function (Request $request) {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado');
        }

        // Validação simples
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        // Cria no banco
        Administradora::create([
            'nome' => $request->nome
        ]);

        // Redireciona de volta ao painel
        return redirect()->route('admin.panel')
            ->with('status', 'Administradora cadastrada com sucesso!');
    })->name('admin.administradoras.store');

    // Página para criar Usuário (formulário)
    Route::get('/usuarios/create', function () {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.usuarios.create');
    })->name('admin.usuarios.create');

    // Recebe os dados do formulário de Usuário e salva
    Route::post('/usuarios', function (Request $request) {
        if (Auth::user()->categoria !== 'admin') {
            abort(403, 'Acesso não autorizado');
        }

        // Validação simples
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        // Cria o usuário no banco
        User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'categoria'         => 'user',  // Ou outro valor padrão
            'administradora_id' => $request->administradora_id, 
        ]);

        return redirect()->route('admin.panel')
            ->with('status', 'Usuário cadastrado com sucesso!');
    })->name('admin.usuarios.store');

    // As rotas que usam o UserController
    // (lista, edição, exclusão)
    Route::get('/usuarios', [UserController::class, 'index'])
        ->name('admin.usuarios.index');

    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])
        ->name('admin.usuarios.edit');

    Route::patch('/usuarios/{user}', [UserController::class, 'update'])
        ->name('admin.usuarios.update');
    
    Route::get('/logs', [AdminLogController::class, 'index'])
        ->name('admin.logs.index');

    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])
        ->name('admin.usuarios.destroy');
        
    Route::get('/solicitacoes', [AdminSolicitacaoController::class, 'index'])
        ->name('admin.solicitacoes.index');

    // Visualizar detalhes de uma solicitação
    Route::get('/solicitacoes/{solicitacao}', [AdminSolicitacaoController::class, 'show'])
        ->name('admin.solicitacoes.show');

    // Formulário para despachar solicitação (atribuir funcionário)
    Route::get('/solicitacoes/{solicitacao}/despacho', [AdminSolicitacaoController::class, 'editDespacho'])
        ->name('admin.solicitacoes.editDespacho');

    // Enviar despacho / atualizar status
    Route::patch('/solicitacoes/{solicitacao}', [AdminSolicitacaoController::class, 'update'])
        ->name('admin.solicitacoes.update');
    
    Route::get('/journeys', [AdminJourneyController::class, 'index'])->name('admin.journeys.index');
        // Form de criar
    Route::get('/journeys/create', [AdminJourneyController::class, 'create'])->name('admin.journeys.create');
        // Salvar
    Route::post('/journeys', [AdminJourneyController::class, 'store'])->name('admin.journeys.store');
        // Form de editar
    Route::get('/journeys/{journey}/edit', [AdminJourneyController::class, 'edit'])->name('admin.journeys.edit');
        // Atualizar
    Route::patch('/journeys/{journey}', [AdminJourneyController::class, 'update'])->name('admin.journeys.update');
        // Excluir
    Route::delete('/journeys/{journey}', [AdminJourneyController::class, 'destroy'])->name('admin.journeys.destroy');

    Route::get('/faqs', [AdminFaqController::class, 'index'])->name('admin.faqs.index');
    Route::get('/faqs/create', [AdminFaqController::class, 'create'])->name('admin.faqs.create');
    Route::post('/faqs', [AdminFaqController::class, 'store'])->name('admin.faqs.store');
    Route::get('/faqs/{faq}/edit', [AdminFaqController::class, 'edit'])->name('admin.faqs.edit');
    Route::patch('/faqs/{faq}', [AdminFaqController::class, 'update'])->name('admin.faqs.update');
    Route::delete('/faqs/{faq}', [AdminFaqController::class, 'destroy'])->name('admin.faqs.destroy');
});

// Rotas que exigem login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Agrupe as rotas para solicitacoes e exija login
Route::middleware('auth')->group(function () {
    // Listar solicitações do usuário
    Route::get('/solicitacoes', [SolicitacaoController::class, 'index'])
        ->name('solicitacoes.index');

    // Formulário de nova solicitação
    Route::get('/solicitacoes/create', [SolicitacaoController::class, 'create'])
        ->name('solicitacoes.create');

    // Salvar nova solicitação
    Route::post('/solicitacoes', [SolicitacaoController::class, 'store'])
        ->name('solicitacoes.store');

    // Exibir detalhes de uma solicitação
    Route::get('/solicitacoes/{solicitacao}', [SolicitacaoController::class, 'show'])
        ->name('solicitacoes.show');
});

Route::get('/faqs/search', [FaqController::class, 'search'])->name('faqs.search');


Route::middleware('auth')->group(function () {
    Route::get('/financeiro', [FinanceiroController::class, 'index'])->name('financeiro');
    Route::post('/financeiro/pagar', [FinanceiroController::class, 'pagarFatura'])->name('financeiro.pagar');
});

Route::middleware('auth')->prefix('admin')->group(function() {
    Route::get('/financeiro', [AdminFinanceiroController::class, 'index'])->name('admin.financeiro.index');
    Route::get('/financeiro/create', [AdminFinanceiroController::class, 'create'])->name('admin.financeiro.create');
    Route::post('/financeiro', [AdminFinanceiroController::class, 'store'])->name('admin.financeiro.store');
    Route::get('/financeiro/{fatura}/edit', [AdminFinanceiroController::class, 'edit'])->name('admin.financeiro.edit');
    Route::patch('/financeiro/{fatura}', [AdminFinanceiroController::class, 'update'])->name('admin.financeiro.update');
    Route::delete('/financeiro/{fatura}', [AdminFinanceiroController::class, 'destroy'])->name('admin.financeiro.destroy');
});

// Importa as rotas de autenticação (geralmente definidas no arquivo auth.php)
require __DIR__.'/auth.php';
