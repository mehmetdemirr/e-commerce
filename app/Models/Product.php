<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'sku',
        'category_id',
        'business_id',
        'brand_id',
        'discount',
        'shipping_cost',
        'weight',
        'dimensions',
        'views',
        'sales',
        'rating',
        'status'
    ];

    /**
     * Get the user that owns the product.
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
