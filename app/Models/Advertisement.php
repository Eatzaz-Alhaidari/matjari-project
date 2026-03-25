<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'title',
        'image',
        'description',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
