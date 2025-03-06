<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes';

    protected $fillable = [
        'user_id',
        'assunto',
        'descricao',
        'categoria',
        'status',
        'anexo',
    ];

    // Relacionamento: uma solicitação pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funcionario()
{
    return $this->belongsTo(User::class, 'atendido_por');
}

}
