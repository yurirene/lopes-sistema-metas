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
    public function index()
    {
        try {
            
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()->back()->withErrors(['Erro ao realizar essa operação.'])->withInput();
        }
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
}
