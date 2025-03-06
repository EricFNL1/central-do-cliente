<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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



// Rotas protegidas pelo middleware "auth"
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Importa as rotas de autenticação (geralmente definidas no arquivo auth.php)
require __DIR__.'/auth.php';
