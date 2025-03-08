<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['client_id', 'admin_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
