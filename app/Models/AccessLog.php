<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'accessed_at',
        'ip_address',
        'user_agent',
    ];

    // Se preferir, você pode desabilitar os timestamps automáticos
    // public $timestamps = false;
}
