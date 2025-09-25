<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'category_id',
        'sku',
        'stock_quantity',
        'is_active',
        'meta_data',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'meta_data' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
