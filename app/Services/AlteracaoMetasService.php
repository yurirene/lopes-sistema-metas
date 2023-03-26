<?php

namespace App\Services;

use App\Models\Permissao;
use App\Models\PlanilhaItem;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlteracaoMetasService
{
    public const APROVADO = 1;
    /**
     * Atualizar
     *
     * @param array $request
     * @return void
     */
    public static function atualizar(array $request): void
    {
        try {
            $ids = explode(',', $request['ids']);
            if ($request['tipo'] == self::APROVADO) {
                self::aprovar($ids);
                return;
            }
            self::reprovar($ids);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Aprovar solicitações
     * - substitui a meta antiga e limpa a nova
     *
     * @param array $ids
     * @return void
     */
    public static function aprovar(array $ids)
    {
        try {
            $itens = PlanilhaItem::whereIn('id', $ids)->get();
            DB::beginTransaction();
            foreach ($itens as $item) {
                $novaMeta = $item->nova_meta;
                $item->update([
                    'nova_meta' => null,
                    'meta_valor' => $novaMeta,
                    'status' => self::APROVADO
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function reprovar(array $ids)
    {
        try {
            $itens = PlanilhaItem::whereIn('id', $ids)->get();
            DB::beginTransaction();
            foreach ($itens as $item) {
                $item->update([
                    'nova_meta' => null,
                    'status' => self::APROVADO
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
