<?php

namespace App\Http\Controllers;

use App\DataTables\PlanilhaDataTable;
use App\Services\PlanilhaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanilhaController extends Controller
{
    public function index(PlanilhaDataTable $dataTable)
    {
        return $dataTable->render('planilha.index');
    }

    public function store(Request $request)
    {
        try {
            PlanilhaService::importar($request);
            return redirect()->route('planilha.index')
            ->with(['mensagem' => [
                    'tipo' => 'success',
                    'mensagem' => 'Registro salvo com sucesso!'
                ]
            ]);
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
