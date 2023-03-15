<?php

namespace App\Services;

use App\Imports\PlanilhaImport;
use App\Models\Planilha;
use App\Models\PlanilhaItem;
use App\Models\Supervisor;
use App\Models\Vendedor;
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
            $rows = SimpleExcelReader::create($request->planilha, 'csv')
                ->useDelimiter(';')
                ->getRows();
            DB::beginTransaction();
            $planilha = Planilha::create([
                'referencia' => '03/2023',
                'user_id' => auth()->user()->id
            ]);
            $supervisores = [];
            $vendedores = [];
            $rows->each(function (array $row) use ($planilha, &$supervisores, &$vendedores) {
                if (!isset($supervisores[$row['cod_supervisor']])) {
                    $supervisor = Supervisor::create([
                        'codigo' => $row['cod_supervisor'],
                        'nome' => $row['supervisor']
                    ]);
                    $supervisores[$supervisor->codigo] = $supervisor->id;
                }
                if (!isset($vendedores[$row['cod_representante']])) {
                    $vendedor = Vendedor::create([
                        'codigo' => $row['cod_representante'],
                        'nome' => $row['representante'],
                        'supervisor_id' => $supervisores[$row['cod_supervisor']]
                    ]);
                    $vendedores[$vendedor->codigo] = $vendedor->id;
                }
                PlanilhaItem::create([
                    "data" => $row["data"],
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
                    'cod_representante' => $row['cod_representante'],
                    'cod_supervisor' => $row['cod_supervisor'],
                    'planilha_id' => $planilha->id
                ]);
            });
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw $th;
        }
    }
    public static function clean($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }
}
