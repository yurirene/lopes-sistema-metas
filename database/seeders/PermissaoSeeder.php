<?php

namespace Database\Seeders;

use App\Models\Permissao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissoes = [
            [
                'name' => 'permite_sobreescrever_planilha',
                'descricao' => 'Permite Sobreescrever Planilha',
            ],
            [
                'name' => 'permite_apagar_planilha',
                'descricao' => 'Permite Apagar Planilha',
            ],
            [
                'name' => 'permite_apagar_item_planilha',
                'descricao' => 'Permite Apagar Item da Planilha',
            ],

        ];
        DB::beginTransaction();
        try {
            foreach ($permissoes as $permissao) {
                Permissao::updateOrCreate(
                    [
                        'name' => $permissao['name']
                    ],
                    [
                        'name' => $permissao['name'],
                        'descricao' => $permissao['descricao']
                    ]
                );
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getFile(), $th->getLine());
        }
    }
}
