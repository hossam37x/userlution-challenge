<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory,Filterable;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'decimal:2',
        'features' => 'array',
        'specifications' => 'array',
        'stock_quantity' => 'integer',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that owns the product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Check if product is available for a specific age
     */
    public function isAvailableForAge(?int $age): bool
    {
        if ($age === null) {
            return false;
        }
        if (!$this->category->is_age_restricted) {
            return true;
        }

        return $age >= $this->category->min_age && $age <= $this->category->max_age;
    }

    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Check if product is in stock
     */
    public function getIsInStockAttribute(): bool
    {
        return $this->in_stock && $this->stock_quantity > 0;
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for products available for specific age
     */
    public function scopeAgeRestriction($query, ?int $age)
    {
        if ($age === null) {
            return $query->whereHas('category', function ($q) {
                $q->where('is_age_restricted', false);
            });
        }

        return $query->where(function ($q) use ($age) {
            $q->whereHas('category', function ($q2) use ($age) {
                $q2->where('is_age_restricted', false);
            })->orWhereHas('category', function ($q2) use ($age) {
                $q2->where('is_age_restricted', true)
                    ->where('min_age', '<=', $age)
                    ->where('max_age', '>=', $age);
            });
        });
    }
}
