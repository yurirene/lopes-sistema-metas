<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory, Auditable;
    protected $table = 'perfis';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
