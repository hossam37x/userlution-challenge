<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(2, true),
            'price' => $this->faker->randomFloat(2, 9.99, 1999.99),
            'category_id' => null, // Will be set by seeder or forCategory()
            'features' => $this->faker->words(5),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'in_stock' => $this->faker->boolean(80),
            'min_age' => $this->faker->randomElement([0, 3, 6, 12, 16, 18, 21]),
        ];
    }

    public function forCategory(Category $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $category->id,
        ]);
    }

    public function electronics(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement([
                'Wireless Headphones',
                'Smart Watch',
                'Gaming Laptop',
                'Bluetooth Speaker',
                'USB-C Hub',
            ]) . ' ' . $this->faker->randomElement(['Pro', 'Ultra', 'Plus', 'Max']),
            'price' => $this->faker->randomFloat(2, 99.99, 1999.99),
            'features' => [
                'Wireless Connectivity',
                'Long Battery Life',
                'Premium Build Quality',
                'Fast Charging',
                'Latest Technology',
            ],
            'min_age' => 0,
        ]);
    }

    public function clothing(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['Cotton', 'Premium', 'Designer']) . ' ' .
                     $this->faker->randomElement(['T-Shirt', 'Jeans', 'Jacket', 'Hoodie', 'Sweater']),
            'price' => $this->faker->randomFloat(2, 19.99, 149.99),
            'features' => [
                '100% Premium Material',
                'Machine Washable',
                'Comfortable Fit',
                'Durable Construction',
                'Style Versatile',
            ],
            'min_age' => 0,
        ]);
    }

    public function books(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 14.99, 59.99),
            'features' => [
                $this->faker->numberBetween(200, 800) . '+ Pages',
                'Comprehensive Content',
                'Expert Author',
                'Updated Edition',
                'Practice Exercises',
            ],
            'min_age' => $this->faker->randomElement([0, 12, 16]),
        ]);
    }

    public function home(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['Smart', 'Premium', 'Professional']) . ' ' .
                     $this->faker->randomElement(['Coffee Maker', 'Air Purifier', 'Vacuum Cleaner', 'Blender', 'Toaster']),
            'price' => $this->faker->randomFloat(2, 49.99, 499.99),
            'features' => [
                'Smart Features',
                'Energy Efficient',
                'Easy to Clean',
                'Durable Design',
                'Warranty Included',
            ],
            'min_age' => 0,
        ]);
    }

    public function sports(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => $this->faker->randomElement(['Professional', 'Premium', 'Elite']) . ' ' .
                     $this->faker->randomElement(['Yoga Mat', 'Dumbbells', 'Resistance Bands', 'Exercise Ball', 'Foam Roller']),
            'price' => $this->faker->randomFloat(2, 19.99, 199.99),
            'features' => [
                'Professional Grade',
                'Durable Material',
                'Ergonomic Design',
                'Non-slip Surface',
                'Portable',
            ],
            'min_age' => $this->faker->randomElement([0, 12]),
        ]);
    }

    public function ageRestricted(): static
    {
        return $this->state(fn (array $attributes) => [
            'min_age' => 21,
        ]);
    }

    public function withRealImages(): static
    {
        return $this->state(fn (array $attributes) => []);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
            'in_stock' => false,
        ]);
    }

    public function inStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => $this->faker->numberBetween(20, 100),
            'in_stock' => true,
        ]);
    }
}
