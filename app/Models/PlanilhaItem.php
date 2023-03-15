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

    const APROVADO = "<span class='badge bg-success'>Aprovado</span>";
    const AGUARDANDO = "<span class='badge bg-warning'>Aguardando</span>";
    const LABELS = [
        0 => self::AGUARDANDO,
        1 => self::APROVADO
    ];

    public function getStatusFormatadoAttribute()
    {
        return self::LABELS[$this->status];
    }
}
