<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    use Auditable;
    protected $table = 'vendedores';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
