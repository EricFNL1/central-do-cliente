<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treinamento extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'conteudo',
        'categoria_id',
    ];
    

    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'categoria_id');
}


public function progressos()
{
    return $this->hasMany(TreinamentoProgress::class);
}
}
