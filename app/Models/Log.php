<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'auditable';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
