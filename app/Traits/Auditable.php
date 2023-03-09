<?php

namespace App\Traits;

use App\Services\Log\LogService;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function boot()
    {
        parent::boot();

        // create a event to happen on updating
        static::updating(function ($table) {
            $usuario = Auth::id() ?: null;
            $acao = 'updating';

            LogService::store($table, $usuario, $acao);
        });

        // create a event to happen on saving
        static::created(function ($table) {
            $usuario = Auth::id() ?: null;
            $acao = 'created';

            LogService::store($table, $usuario, $acao);
        });

        // create a event to happen on deleting
        static::deleting(function ($table) {
            $usuario = Auth::id() ?: null;
            $acao = 'deleting';

            LogService::store($table, $usuario, $acao);
        });
    }
}
