<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nome', 'imagem'];

    // Se a categoria tiver um relacionamento com treinamentos:
    public function treinamentos()
    {
        return $this->hasMany(Treinamento::class, 'categoria_id');
    }
    
}