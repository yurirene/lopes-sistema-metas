<?php

namespace App\Http\Controllers;

use App\DataTables\SupervisorDataTable;
use App\DataTables\VendedorDataTable;
use App\Models\Supervisor;
use App\Services\PermissaoService;
use App\Services\SupervisorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupervisorController extends Controller
{
    public function index(SupervisorDataTable $dataTable)
    {
        return $dataTable->render('supervisor.index');
    }

    public function show(Supervisor $supervisor)
    {
        $dataTable = new VendedorDataTable($supervisor);
        return $dataTable->render('supervisor.show', [
            'supervisor' => $supervisor
        ]);
    }

    public function create()
    {
        return view('supervisor.form', [
            'permissoes' => PermissaoService::listarPermissoes(),
            'usuario' => null
        ]);
    }

    public function edit(Supervisor $supervisor)
    {
        return view('supervisor.form', [
            'supervisor' => $supervisor,
            'permissoes' => PermissaoService::listarPermissoes($supervisor),
            'usuario' => $supervisor->usuario
        ]);
    }


    public function store(Request $request)
    {

        try {
            SupervisorService::store($request->all());
            return redirect()->route('supervisores.index')
                ->with(['mensagem' => [
                        'tipo' => 'success',
                        'mensagem' => 'Supervisor cadastrado com sucesso!'
                    ]
                ]);
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()
                ->back()
                ->withErrors(['Erro ao realizar essa operação.'])
                ->withInput();
        }
    }

    public function update(Supervisor $supervisor, Request $request)
    {

        try {
            SupervisorService::update($supervisor, $request->all());
            return redirect()->route('supervisores.index')
                ->with(['mensagem' => [
                        'tipo' => 'success',
                        'mensagem' => 'Dados atualizados com sucesso!'
                    ]
                ]);
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()
                ->back()
                ->withErrors(['Erro ao realizar essa operação.'])
                ->withInput();
        }
    }
}
