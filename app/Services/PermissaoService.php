<?php

namespace App\Services;

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
}
