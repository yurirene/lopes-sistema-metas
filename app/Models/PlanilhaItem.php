<?php

namespace App\Models;

use App\Casts\DateCast;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class PlanilhaItem extends Model
{
    use Auditable;

    protected $table = 'planilha_items';
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $casts = ['data' => DateCast::class];

    const APROVADO = "<span class='badge bg-light-success'>Aprovado</span>";
    const AGUARDANDO = "<span class='badge bg-light-warning'>Aguardando</span>";
    const LABELS = [
        0 => self::AGUARDANDO,
        1 => self::APROVADO
    ];

    public function getStatusFormatadoAttribute()
    {
        return self::LABELS[$this->status];
    }

    public function getMetaValorFormatadoAttribute()
    {
        if (strpos($this->meta_valor, ',')) {
            return $this->meta_valor;
        }
        return number_format($this->meta_valor, 2, ',', '.');
    }

    public function getMetaValorNumericoAttribute()
    {
        $valor = str_replace('.', '', $this->meta_valor);
        $valor = str_replace(',', '.', $valor);
        return floatval($valor);
    }

    public function getCobMetaNumericoAttribute()
    {
        $valor = str_replace('.', '', $this->cob_meta);
        $valor = str_replace(',', '.', $valor);
        return floatval($valor);
    }

    public function getValorMetaAttribute()
    {
        $valor = '';
        if (strpos($this->meta_valor, ',')) {
            $valor = $this->meta_valor;
        } else {
            $valor = number_format($this->meta_valor, 2, ',', '.');
        }
        $valor .= !is_null($this->nova_meta)
            ? " <span class='text-warning'>($this->nova_meta)</span>"
            : "";
        return $valor;
    }

    public function planilha()
    {
        return $this->belongsTo(Planilha::class, 'planilha_id');
    }
}
