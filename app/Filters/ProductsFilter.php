<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductsFilter extends Filter
{
    /**
     * Filter by category ID.
     *
     * @param  int  $categoryId
     * @return void
     */
    public function category($categoryId)
    {
        $this->builder->where('category_id', $categoryId);
    }

    /**
     * Filter by search term in product name or description.
     *
     * @param  string  $searchTerm
     * @return void
     */
    public function search($searchTerm)
    {
        $this->builder->where(function (Builder $query) use ($searchTerm) {
            $query->where('name', 'like', "{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
        });
    }

    /**
     * Filter by minimum price.
     *
     * @param  float  $minPrice
     * @return void
     */
    public function priceFrom($minPrice)
    {
        $this->builder->where('price', '>=', (float)$minPrice);
    }

    /**
     * Filter by maximum price.
     *
     * @param  float  $maxPrice
     * @return void
     */
    public function priceTo($maxPrice)
    {
        $this->builder->where('price', '<=', (float)$maxPrice);
    }

    /**
     * Sort products by specified criteria.
     *
     * @param  string  $sortBy
     * @return void
     */
    public function sort($sortBy)
    {
        switch ($sortBy) {
            case 'name_asc':
                $this->builder->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $this->builder->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $this->builder->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $this->builder->orderBy('price', 'desc');
                break;
            default:
                $this->builder->orderBy('created_at', 'desc');
                break;
        }
    }
}
