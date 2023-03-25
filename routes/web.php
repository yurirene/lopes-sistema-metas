<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PlanilhaController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\VendedorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('planilha', PlanilhaController::class)->names('planilha')->except(['destroy']);
    Route::get('/planilha-delete/{planilha}', [PlanilhaController::class, 'delete'])->name('planilha.delete');
    Route::get('/planilha-delete-item/{item}', [PlanilhaController::class, 'deleteItem'])->name('planilha.delete.item');
    Route::post('/planilha-atualizar-valor', [PlanilhaController::class, 'atualizarValor'])->name('planilha.atualizar-valor');

    Route::resource('supervisores', SupervisorController::class)->names('supervisores')->except(['destroy']);
    Route::get('/supervisores-delete/{supervisor}', [SupervisorController::class, 'delete'])->name('supervisores.delete');

    Route::resource('vendedores', VendedorController::class)->names('vendedores')->except(['destroy']);
    Route::get('/vendedores-delete/{funcionario}', [VendedorController::class, 'delete'])->name('vendedores.delete');

    Route::resource('usuarios', UsuarioController::class)->names('usuarios')->except(['destroy']);
    Route::get('/usuarios-delete/{usuario}', [UsuarioController::class, 'delete'])->name('usuarios.delete');
});
