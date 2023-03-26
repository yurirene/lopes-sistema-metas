<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Services\DepartamentoService;
use App\Services\PerfilService;
use App\Services\UsuarioService;
use App\Traits\ControllerPadraoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        try {
            return $dataTable->render('usuarios.index');
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()
                ->route('home')
                ->withErrors(['Erro ao realizar essa operação.']);
        }
    }

    public function create(User $usuario)
    {
        return view('usuarios.form', [
            'perfis' => PerfilService::getToSelect()
        ]);
    }

    public function store(Request $request)
    {
        try {
            UsuarioService::store($request->all());
            return redirect()->route('usuarios.index')
                ->with(['mensagem' => ['tipo' => 'success', 'mensagem' => 'Registro salvo com sucesso!']]);
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()->back()->withErrors(['Erro ao realizar essa operação.'])->withInput();
        }
    }

    public function edit(User $usuario)
    {
        return view('usuarios.form', [
            'usuario' => $usuario,
            'perfis' => PerfilService::getToSelect()
        ]);
    }

    public function update(User $usuario, Request $request)
    {
        try {
            UsuarioService::update($request->all(), $usuario);
            return redirect()->route('usuarios.index')
                ->with(['mensagem' => ['tipo' => 'success', 'mensagem' => 'Registro atualizado com sucesso!']]);
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()->back()->withErrors(['Erro ao realizar essa operação.'])->withInput();
        }
    }
}
