<?php

namespace App\Services\Log;

use Exception;
use App\Models\Log as LogModel;
use Illuminate\Support\Facades\Log;

class LogService
{
    public static function store($model, $usuario, $acao)
    {
        $oldValues = [];
        $dirty = $model->getDirty();
        $novos = json_encode($dirty);

        foreach ($dirty as $dirtyColumns => $value) {
            $oldValues[$dirtyColumns] = $model->getOriginal($dirtyColumns);
        }

        $table = $model->getTable();
        $model->getKey() ? $tableId = $model->getKey() : $tableId = null;
        $colunas = array_keys($oldValues);

        if ($acao == 'created') {
            $antigos = null;
        } else if ($acao == 'deleting') {
            $colunas = array_keys($model->getOriginal());
            $antigos = json_encode($model->getOriginal());
            $novos = null;
        } else {
            $antigos = json_encode($oldValues);
        }

        try {
            return LogModel::create([
                'table' => $table,
                'table_id' => $tableId,
                'acao' => $acao,
                'coluna' => json_encode($colunas),
                'valor_antigo' => $antigos,
                'valor_novo' => $novos,
                'user_id' => $usuario
            ]);
        } catch (Exception $e) {
            self::setErrosLog($e);
            return false;
        }
    }


    /**
     *  Padronizando registro de logs dos erros
     *  @param $exception
     */
    static public function setErrosLog($exception)
    {
        $trace = $exception->getTrace()[array_key_first($exception->getTrace())];
        $message = $exception->getMessage();

        $errors = collect($trace)
            ->except(['type', 'function', 'args', 'class'])
            ->merge(['message' => $message])->toArray();

        Log::error($errors);
    }
}
