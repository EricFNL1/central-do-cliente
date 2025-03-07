<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'user_id',
        'tipo',
        'descricao',
        'valor',
        'status',
        'data_transacao',
    ];

    protected $casts = [
        'data_transacao' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
