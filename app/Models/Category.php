<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $guarder = ['id','created_at', 'updated_at'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'is_age_restricted' => 'boolean',
    ];

    /**
     * Get all products for this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include categories suitable for the given user's age.
     *
     * @param Builder $query
     * @param User|null $user
     * @return Builder
     */
    public function scopeAgeRestriction(Builder $query, ?User $user) {
        return $query->when($user, function (Builder $query) use ($user) {

            return $query->where('min_age', '<=', $user->age)->where('max_age', '>=', $user->age);
        })->orWhere('is_age_restricted', false);
    }
}
