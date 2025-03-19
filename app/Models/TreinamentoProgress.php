<?php

// app/Models/TreinamentoProgress.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TreinamentoProgress extends Model
{
    protected $table = 'treinamento_progress';

    protected $fillable = [
        'user_id', 'treinamento_id', 'progresso'
    ];

    public function treinamento()
    {
        return $this->belongsTo(Treinamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
