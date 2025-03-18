<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treinamento extends Model
{
    protected $fillable = [
        'titulo',
        'descricao',
        'link',
        'categoria_id',
    ];
    

    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'categoria_id');
}
}
