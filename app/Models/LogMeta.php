<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMeta extends Model
{
    protected $table = 'log_metas';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
