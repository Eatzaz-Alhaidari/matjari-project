<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotResponse extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'response'
    ];
}
