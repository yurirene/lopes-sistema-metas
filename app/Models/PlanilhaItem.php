<?php

namespace App\Models;

use App\Casts\DateCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\VarDumper\Caster\DateCaster;

class PlanilhaItem extends Model
{
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
}
