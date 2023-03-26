<?php

namespace App\Services;

use App\Models\Permissao;
use App\Models\Supervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class PermissaoService
{

    /**
     * Verifica Permissão se o usuário tem a permissão informada
     *
     * @param string $permissao
     * @return boolean
     */
    public static function verificaPermissao(string $permissao): bool
    {
        $permissoes = !is_null(auth()->user()->permissao)
            ? auth()->user()->permissao->pluck('name')->toArray()
            : [];
        return in_array($permissao, $permissoes);
    }

    /**
     * Listar Permissões para o select do supervisor
     */
    public static function listarPermissoes(Supervisor $supervisor = null): array
    {
        try {
            $permissoes = [];
            if (!is_null($supervisor) && $supervisor->usuario) {
                $permissoes = $supervisor->usuario->permissao->pluck('id')->toArray();
            }
            return Permissao::get()
                ->map(function ($item) use ($permissoes) {
                    $item->checked = false;
                    if (in_array($item->id, $permissoes)) {
                        $item->checked = true;
                    }
                    return $item;
                })
                ->toArray();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
