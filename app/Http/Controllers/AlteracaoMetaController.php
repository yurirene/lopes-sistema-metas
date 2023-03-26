<?php

namespace App\Http\Controllers;

use App\DataTables\AlteracaoMetasDataTable;
use App\Services\AlteracaoMetasService;
use App\Services\PlanilhaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    public function atualizar(Request $request)
    {
        try {
            AlteracaoMetasService::atualizar($request->all());
            response()->json('Sucesso!', 200);
        } catch (Throwable $th) {
            dd($th->getMessage());
            response()->json('Erro!', 505);
        }
    }
}
