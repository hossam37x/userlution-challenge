<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(10),
        ];
    }

    public function electronics(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Latest gadgets, devices, and electronic accessories',
        ]);
    }

    public function clothing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and apparel for all occasions',
        ]);
    }

    public function books(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books, e-books, and educational materials',
        ]);
    }

    public function home(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Home & Kitchen',
            'slug' => 'home',
            'description' => 'Home appliances, kitchenware, and decor',
        ]);
    }

    public function sports(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Sports & Fitness',
            'slug' => 'sports',
            'description' => 'Sports equipment, fitness gear, and outdoor activities',
        ]);
    }
}
