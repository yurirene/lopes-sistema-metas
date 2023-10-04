<?php

namespace App\Imports;

use App\Models\PlanilhaItem;
use App\Models\Supervisor;
use App\Models\Vendedor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PlanilhaImport implements ToCollection, WithBatchInserts, WithCustomCsvSettings, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        try {
            DB::beginTransaction();
            $supervisor = null;
            $vendedor = null;
            foreach ($collection as $row) {
                if (
                    is_null($supervisor)
                    || $supervisor->cod_supervisor != $row['cod_supervisor']
                ) {
                    $supervisor = Supervisor::updateOrCreate(
                        [
                            'codigo' => $row['cod_supervisor']
                        ],
                        [
                            'codigo' => $row['cod_supervisor'],
                            'nome' => $row['supervisor']
                        ]
                    );
                }
                if (
                    is_null($vendedor)
                    || $vendedor->codigo != $row['cod_representante']
                ) {
                    $vendedor = Vendedor::updateOrCreate(
                        [
                            'codigo' => $row['cod_representante']
                        ],
                        [
                            'codigo' => $row['cod_representante'],
                            'nome' => $row['representante'],
                            'supervisor_id' => $supervisor->id
                        ]
                    );
                }
                PlanilhaItem::updateOrCreate([
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
                    "tipo_subgrupo_produto" => $row["tipo_subgrupo_produto"],
                    'vendedor_id' => $vendedor->id,
                    'supervisor_id' => $supervisor->id
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
