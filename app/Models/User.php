<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo_path',
        'status',
        'ban_reason',
        'google_id',
        'role',
        'has_biometric',
        'biometric_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'has_biometric'     => 'boolean',
    ];

    /**
     * Get the single primary store for the vendor.
     * تم الإبقاء على نسخة واحدة فقط هنا لحل مشكلة الـ Fatal Error.
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'user_id', 'id');
    }

    /**
     * Get the stores associated with the user.
     */
    public function stores()
    {
        return $this->hasMany(Store::class, 'user_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}