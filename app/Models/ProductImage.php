<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'product_id',
        'image_url',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        /**
     * Resmin tam URL'sini al
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->attributes['image_url']);
    }

    // In ProductImage model
    public function getFilePathAttribute()
    {
        // Remove 'http://localhost/storage/' from the image_url to get the path for storage operations
        return str_replace(asset('storage/'), '', $this->attributes['image_url']);
    }
}
