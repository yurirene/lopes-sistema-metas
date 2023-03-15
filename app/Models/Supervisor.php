<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisores';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function vendedores()
    {
        return $this->hasMany(Vendedor::class, 'supervisor_id');
    }

}
