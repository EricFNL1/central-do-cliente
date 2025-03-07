<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administradora extends Model
{
    protected $fillable = ['nome']; // Adicione outros campos, se necessário

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
