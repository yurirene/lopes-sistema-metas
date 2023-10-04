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

    public function atualizar(Request $request)
    {
        try {
            AlteracaoMetasService::atualizar($request->all());
            response()->json('Sucesso!', 200);
        } catch (Throwable $th) {
            response()->json('Erro!', 505);
        }
    }

    public function definir(Request $request)
    {
        try {
            $this->authorize('menu', ['gerente']);
            $dados['ids'] = $request->id;
            AlteracaoMetasService::atualizar($dados, true);
            response()->json('Sucesso!', 200);
        } catch (Throwable $th) {
            response()->json('Erro!', 505);
        }
    }
}
