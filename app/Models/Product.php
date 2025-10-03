<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
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
        if (!$this->age_restricted) {
            return true;
        }

        if ($age === null) {
            return false;
        }

        $minAge = $this->min_age ?? 18;
        $maxAge = $this->max_age ?? 30;

        return $age >= $minAge && $age <= $maxAge;
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
    public function scopeAvailableForAge($query, ?int $age)
    {
        if ($age === null) {
            return $query->where('age_restricted', false);
        }

        return $query->where(function ($q) use ($age) {
            $q->where('age_restricted', false)
              ->orWhere(function ($subQ) use ($age) {
                  $subQ->where('age_restricted', true)
                       ->where(function ($ageQ) use ($age) {
                           $ageQ->where('min_age', '<=', $age)
                                ->where('max_age', '>=', $age);
                       });
              });
        });
    }
}
