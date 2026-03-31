<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotRule extends Model
{
    protected $fillable = [
        'store_id',
        'trigger_keyword',
        'response_text',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
