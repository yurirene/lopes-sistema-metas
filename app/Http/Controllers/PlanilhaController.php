<?php

namespace App\Http\Controllers;

use App\DataTables\PlanilhaDataTable;
use App\DataTables\PlanilhaItemDataTable;
use App\Models\Planilha;
use App\Models\PlanilhaItem;
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
                        'mensagem' => 'Planilha Importada com Sucesso!'
                    ]
                ]);
        } catch (\Throwable $th) {
            $mensagem = 'Erro ao realizar essa operação.';
            if ($th->getCode() == 505) {
                $mensagem = $th->getMessage();
            }
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return redirect()
                ->back()
                ->withErrors([$mensagem])
                ->withInput();
        }
    }

    public function show(PlanilhaItemDataTable $dataTable)
    {

        $filtros = PlanilhaService::filtros();
        return $dataTable->render('planilha.show', [
            'filtros' => $filtros
        ]);
    }

    public function delete(Planilha $planilha)
    {
        try {
            PlanilhaService::apagarPlanilha($planilha->referencia);
            return redirect()->route('planilha.index')
                ->with(['mensagem' => [
                        'tipo' => 'success',
                        'mensagem' => 'Planilha Removida com Sucesso!'
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

    public function atualizarValor(Request $request)
    {
        try {
            PlanilhaService::atualizarValor($request->all());
            return response()->json(['Valor Atualizado!'], 200);
        } catch (\Throwable $th) {
            Log::error([
                'erro' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);

            return response()->json(['Erro ao atualizar!'], 500);
        }
    }

    public function deleteItem(PlanilhaItem $item, Request $request)
    {
        try {
            if ($request->user()->cannot('permissao', 'permite_apagar_item_planilha')) {
                return redirect()
                    ->back()
                    ->withErrors(['Você não tem permissão para apagar.']);
            }
            PlanilhaService::deleteItem($item);
            return redirect()->route('planilha.index')
                ->with(['mensagem' => [
                        'tipo' => 'success',
                        'mensagem' => 'Item Removidd com Sucesso!'
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
