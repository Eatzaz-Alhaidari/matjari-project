<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'name',
        'brand',
        'description',
        'full_description',
        'price',
        'cost_price',
        'price_before',
        'stock',
        'min_stock',
        'notes',
        'status',
        'image',
        'three_d_model',
        'three_sixty_images',
        'store_id',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'price_before' => 'decimal:2',
        'stock' => 'integer',
        'min_stock' => 'integer',
        'status' => 'string',
        'three_sixty_images' => 'array',
    ];

    protected $appends = ['three_d_model_url', 'three_sixty_images_urls', 'image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getThreeDModelUrlAttribute()
    {
        return $this->three_d_model ? asset('storage/' . $this->three_d_model) : null;
    }

    public function getThreeSixtyImagesUrlsAttribute()
    {
        if (!$this->three_sixty_images) {
            return [];
        }
        return array_map(function ($path) {
            return asset('storage/' . $path);
        }, $this->three_sixty_images);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
