<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_number',
        'name',
        'slug',
        'slogan',
        'description',
        'commercial_registration',
        'address',
        'logo_path',
        'cover_image_path',
        'support_phone',
        'support_email',
        'shipping_policy',
        'return_policy',
        'accounting_system',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($store) {
            if (!$store->store_number) {
                $store->store_number = 'STR-' . strtoupper(Str::random(8));
            }

            if (!$store->slug) {
                $slug = Str::slug($store->name);
                $count = self::where('slug', 'like', "$slug%")->count();
                $store->slug = $count ? "$slug-$count" : $slug;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}