<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'user_id', 'content'];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
