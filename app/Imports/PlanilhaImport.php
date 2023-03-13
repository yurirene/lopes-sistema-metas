<?php

namespace App\Imports;

use App\Models\PlanilhaItem;
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
            foreach ($collection as $row) {
                dd($row);
                PlanilhaItem::updateOrCreate([
                    "data" => $row["data"],
                    "cod_representante" => $row["cod_representante"],
                    "representante" => $row["representante"],
                    "cod_supervisor" => $row["cod_supervisor"],
                    "supervisor" => $row["supervisor"],
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
                    "tipo_subgrupo_produto" => $row["tipo_subgrupo_produto"]
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            throw $th;
        }
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }
}
