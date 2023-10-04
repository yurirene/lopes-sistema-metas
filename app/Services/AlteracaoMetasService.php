<?php

namespace App\Services;

use App\Models\LogMeta;
use App\Models\Permissao;
use App\Models\PlanilhaItem;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlteracaoMetasService
{
    public const APROVADO = 1;
    public const REPROVADO = 0;
    public const MSG = [
        self::APROVADO => ' aprovou a meta de ',
        self::REPROVADO => ' reprovou a meta de '
    ];


    /**
     * Atualizar o status do item (Aprovado ou Reprovado)
     *
     * @param array $request
     * @return void
     */
    public static function atualizar(array $request, bool $isGerente = false): void
    {
        try {
            $ids = explode(',', $request['ids']);
            if ($isGerente || $request['tipo'] == self::APROVADO) {
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
                $dadosAntigos = self::retornarDadosAntigos($item);
                $novaMeta = $item->nova_meta;
                $item->update([
                    'nova_meta' => null,
                    'meta_valor' => $novaMeta,
                    'status' => self::APROVADO
                ]);
                self::registrarLog($item->toArray(), $dadosAntigos, self::APROVADO);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    /**
     * Reprova a solicitação
     * - Deixa a meta antiga e apaga a nova
     *
     * @param array $ids
     * @return void
     */
    public static function reprovar(array $ids)
    {
        try {
            $itens = PlanilhaItem::whereIn('id', $ids)->get();
            DB::beginTransaction();
            foreach ($itens as $item) {
                $dadosAntigos = self::retornarDadosAntigos($item);
                $item->update([
                    'nova_meta' => null,
                    'status' => self::APROVADO
                ]);
                self::registrarLog($item->toArray(), $dadosAntigos, self::REPROVADO);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    /**
     * Atualizar Valor da Meta
     *
     * @param array $request
     * @return void
     */
    public static function atualizarValor(array $request): void
    {
        try {
            $planilhaItem = PlanilhaItem::find($request['id']);
            if ($planilhaItem->meta_valor_formatado == $request['valor']) {
                return;
            }
            $dadoAntigo = self::retornarDadosAntigos($planilhaItem);
            $planilhaItem->update([
                'nova_meta' => $request['valor'],
                'status' => 0
            ]);
            self::registrarLog($planilhaItem->toArray(), $dadoAntigo);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Registra o log de alterações da meta
     *
     * @param array $item
     * @param array $dados
     * @param boolean|null $respostaGerente
     * @return void
     */
    public static function registrarLog(array $item, array $dados, ?bool $respostaGerente = null ): void
    {
        $chaves = array_keys($dados);
        $campos = [];
        foreach ($chaves as $chave) {
            $campos[$chave] = [
                'antigo' => $dados[$chave],
                'novo' => $item[$chave]
            ];
        }
        $mensagem = auth()->user()->name . " solicitou a alteração da meta";
        if (!is_null($respostaGerente)) {
            $mensagem = auth()->user()->name . self::MSG[$respostaGerente] . $item['meta_valor'];
        }
        LogMeta::create([
            'user_id' => auth()->id(),
            'campos' => json_encode($chave),
            'mensagem' => $mensagem
        ]);
    }

    /**
     * Método para centralizar o retorno dos dados antes da alteração
     *
     * @param PlanilhaItem $planilhaItem
     * @return array
     */
    public static function retornarDadosAntigos(PlanilhaItem $planilhaItem): array
    {
        return $planilhaItem->only(['meta_valor', 'status', 'nova_meta']);
    }
}
