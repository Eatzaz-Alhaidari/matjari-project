<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image', 'status', 'parent_id', 'is_brand', 'brand_logo', 'banner', 'icon', 'is_popular'];

    protected $appends = ['image_url', 'banner_url', 'icon_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner ? asset('storage/' . $this->banner) : null;
    }

    public function getIconUrlAttribute()
    {
        return $this->icon ? asset('storage/' . $this->icon) : null;
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function brands()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_brand', true);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_brand', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
