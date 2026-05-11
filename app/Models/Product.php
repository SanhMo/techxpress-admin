<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'price',
        'price_old',
        'description',
        'specs',
        'image',
        'images',
        'badge',
        'stock',
        'is_active',
        'is_featured',
        'is_flash_sale',
        'flash_sale_sold',
        'flash_sale_total',
    ];
    // ───────────────────────────────────────────────

    protected $casts = [
        'specs'          => 'array',
        'images'         => 'array',
        'is_active'      => 'boolean',
        'is_featured'    => 'boolean',
        'is_flash_sale'  => 'boolean',
    ];

    // Tự tạo slug từ tên
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }
}
