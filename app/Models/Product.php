<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'sku',
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
        'brand_id',
        'warranty_duration',
        'warranty_unit',
        'currency',
        'size',
        'color',
        'region',
    ];

    protected $casts = [
        'price' => 'double',
        'cost_price' => 'double',
        'price_before' => 'double',
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

    public function brand()
    {
        return $this->belongsTo(Category::class, 'brand_id');
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

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * حساب تاريخ الانتهاء بناءً على تاريخ الشراء المخزن
     * 
     * @param \Carbon\Carbon|string $purchaseDate
     * @return \Carbon\Carbon|null
     */
    public function getWarrantyExpiryDate($purchaseDate)
    {
        if (!$this->warranty_duration || !$this->warranty_unit) {
            return null;
        }

        $date = \Carbon\Carbon::parse($purchaseDate);

        return match ($this->warranty_unit) {
            'days' => $date->addDays($this->warranty_duration),
            'months' => $date->addMonths($this->warranty_duration),
            'years' => $date->addYears($this->warranty_duration),
            default => null,
        };
    }
}
