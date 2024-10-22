<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Produto\ProdutoStore;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;


Route::redirect('/', '/login');


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

Route::middleware(['auth'])->group(function () {

    Route::get('/produtos', function () {
        $produtos = Produto::all();

        return view('welcome', [
            'produtos' => $produtos,
        ]);
    })->name('welcome');

    Route::post('/produtos', ProdutoStore::class)->name('produto.store');
});
