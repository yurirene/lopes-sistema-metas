<?php

namespace App\Services;

use App\Imports\PlanilhaImport;
use App\Models\Planilha;
use App\Models\PlanilhaItem;
use App\Models\Supervisor;
use App\Models\Vendedor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelReader;
use Throwable;

class PlanilhaService
{


    public static function importar(Request $request) : void
    {
        try {

            self::validarImportacao($request->toArray());

            $rows = SimpleExcelReader::create($request->planilha, 'csv')
                ->useDelimiter(';')
                ->getRows();
            DB::beginTransaction();
            $planilha = Planilha::create([
                'referencia' => $request->referencia,
                'user_id' => auth()->user()->id
            ]);
            $supervisores = Supervisor::get()->pluck('nome', 'codigo')->toArray();
            $vendedores = Vendedor::get()->pluck('nome', 'codigo')->toArray();
            $rows->each(function (array $row) use ($planilha, &$supervisores, &$vendedores) {

                if (!isset($supervisores[$row['cod_supervisor']])) {
                    $supervisor = Supervisor::updateOrCreate(
                        [
                            'codigo' => $row['cod_supervisor']
                        ],
                        [
                            'codigo' => $row['cod_supervisor'],
                            'nome' => $row['supervisor']
                        ]
                    );
                    $supervisores[$supervisor->codigo] = $supervisor->id;
                }
                if (!isset($vendedores[$row['cod_representante']])) {
                    $vendedor = Vendedor::updateOrCreate([
                        'codigo' => $row['cod_representante'],
                    ], [
                        'codigo' => $row['cod_representante'],
                        'nome' => $row['representante'],
                        'supervisor_id' => $supervisores[$row['cod_supervisor']]
                    ]);
                    $vendedores[$vendedor->codigo] = $vendedor->id;
                }

                PlanilhaItem::create([
                    "data" => $row["data"],
                    'cod_representante' => $row['cod_representante'],
                    'representante' => $row['representante'],
                    'cod_supervisor' => $row['cod_supervisor'],
                    'supervisor' => $row['supervisor'],
                    "cod_gerente" => $row["cod_gerente"],
                    "gerente" => $row["gerente"],
                    "familia_produto" => $row["familia_produto"],
                    "subgrupo_produto" => $row["subgrupo_produto"],
                    "cod_produto" => $row["cod_produto"],
                    "produto" => $row["produto"],
                    "cod_empresa" => $row["cod_empresa"],
                    "empresa" => $row["empresa"],
                    "qtd_meta" => $row["qtd_meta"],
                    "volume_meta_kg" => $row["volume_meta_kg"],
                    "meta_valor" => $row["meta_valor"],
                    "cob_meta" => $row["cob_meta"],
                    "cod_subgrupo_produto" => $row["cod_subgrupo_produto"],
                    "tipo_subgrupo_produto" => self::clean($row["tipo_subgrupo_produto"]),
                    'planilha_id' => $planilha->id
                ]);
            });
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**
     * Verifica se não existe uma planilha para essa referencia,
     *
     *  ** true - Não existe referencia
     *  ** false - Existe referencia
     *
     * @param string $referencia
     * @return bool
     */
    public static function existeReferencia(string $referencia): bool
    {
        return Planilha::where('referencia', $referencia)
            ->get()
            ->isNotEmpty();
    }

    /**
     * Valida de acordo com as regra para importação da planilha
     *
     * @param array $request
     * @return void
     */
    public static function validarImportacao(array $request): void
    {

        $existeReferencia = self::existeReferencia($request['referencia']);
        if (!$existeReferencia) {
            return;
        }
        if (!PermissaoService::verificaPermissao('permite_sobreescrever_planilha')) {
            throw new Exception(
                "Já existe um lançamento para "
                    . $request['referencia']
                    . ' e você não pode alterar' ,
                505
            );
        }
        self::apagarPlanilha($request['referencia']);
    }

    /**
     * Método para apagar planilhas e seus itens
     *
     * @param string $referencia
     * @return void
     */
    public static function apagarPlanilha(string $referencia): void
    {
        try {
            $planilha = Planilha::where('referencia', $referencia)->first();
            $planilha->itens()->delete();
            $planilha->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Método para retornar campos dos filtros
     *
     * @return array
     */
    public static function filtros(): array
    {
        try {
            $idPlanilha = request()->route('planilha') ?? null;
            $supervisores = Supervisor::all()->pluck('nome', 'codigo')->unique();
            $status = ['' => 'Todos', 0 => 'Aguardando', 1 => 'Aprovado'];
            $empresas[''] = 'Todas';
            $empresas += DB::table('planilha_items')
                            ->select('empresa')
                            ->distinct()
                            ->where('planilha_id', '=', $idPlanilha)
                            ->pluck('empresa', 'empresa')
                            ->toArray();
            return [
                'supervisores' => $supervisores,
                'status' => $status,
                'empresas' => $empresas
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    /**
     * Método para deletar item da planilha
     *
     * @param PlanilhaItem $item
     * @return void
     */
    public static function deleteItem(PlanilhaItem $item): void
    {
        try {
            $item->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
