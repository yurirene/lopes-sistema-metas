<?php

namespace App\Http\Controllers;

use App\DataTables\AlteracaoMetasDataTable;
use App\Services\PlanilhaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlteracaoMetaController extends Controller
{

    public function index(AlteracaoMetasDataTable $dataTable)
    {
        try {
            return $dataTable->render('alteracao-metas.index', [
                'filtros' => PlanilhaService::filtros()
            ]);
        } catch (\Throwable $th) {

            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()
                ->route('home')
                ->withErrors(['Não foi possível carregar a tela.']);
        }
    }

    // public function index(AlteracaoMetasDataTable $dataTable)
    // {
    //     try {
    //         return redirect()->route('alteracao-metas.index')
    //             ->with(['mensagem' => [
    //                     'tipo' => 'success',
    //                     'mensagem' => 'Resposta enviada com Sucesso!'
    //                 ]
    //             ]);
    //     } catch (\Throwable $th) {
    //         Log::error([
    //             'erro' => $th->getMessage(),
    //             'line' => $th->getLine(),
    //             'file' => $th->getFile()
    //         ]);

    //         return redirect()
    //             ->back()
    //             ->withErrors(['Erro ao realizar essa operação.'])
    //             ->withInput();
    //     }
    // }
}
