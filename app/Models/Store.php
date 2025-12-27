<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo_path',
        'is_active',

        // ##### الحقول الجديدة التي أضفناها #####
        'commercial_registration',
        'address',
        'slogan',
        'cover_image_path',
        'support_phone',
        'support_email',
        'shipping_policy',
        'return_policy',
        'accounting_system',
    ];


    /**
     * Get the user that owns the store.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}