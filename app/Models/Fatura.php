<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'faturas';

    protected $fillable = [
        'user_id',
        'administradora_id',
        'valor',
        'descricao',       // Agora existe
        'status',
        'data_emissao',
        'data_vencimento',
        'data_pagamento',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }
}
