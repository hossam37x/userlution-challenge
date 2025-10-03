<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch categories
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $books = Category::where('slug', 'books')->first();
        $home = Category::where('slug', 'home')->first();
        $sports = Category::where('slug', 'sports')->first();
        $adultProducts = Category::where('slug', 'adult-personal-products')->first();

        // Create Electronics products
        if ($electronics) {
            Product::factory()
                ->count(5)
                ->forCategory($electronics)
                ->electronics()
                ->withRealImages()
                ->inStock()
                ->create();
        }

        // Create Clothing products
        if ($clothing) {
            Product::factory()
                ->count(5)
                ->forCategory($clothing)
                ->clothing()
                ->withRealImages()
                ->inStock()
                ->create();
        }

        // Create Books
        if ($books) {
            Product::factory()
                ->count(5)
                ->forCategory($books)
                ->books()
                ->withRealImages()
                ->inStock()
                ->create();
        }

        // Create Home products
        if ($home) {
            Product::factory()
                ->count(5)
                ->forCategory($home)
                ->home()
                ->withRealImages()
                ->inStock()
                ->create();

            // Create age-restricted product (wine)
            Product::factory()
                ->forCategory($home)
                ->home()
                ->withRealImages()
                ->create([
                    'name' => 'Premium Wine Collection',
                    'slug' => 'premium-wine-collection',
                    'description' => 'Curated selection of premium wines from renowned vineyards. Perfect for special occasions and wine enthusiasts.',
                    'price' => 299.99,
                    'features' => [
                        '6 Premium Bottles',
                        'Vintage Selection',
                        'Elegant Gift Box',
                        'Tasting Notes Included',
                    ],
                ]);
        }

        // Create Sports products
        if ($sports) {
            Product::factory()
                ->count(5)
                ->forCategory($sports)
                ->sports()
                ->withRealImages()
                ->inStock()
                ->create();
        }

        // Create some out of stock products
        if ($electronics) {
            Product::factory()
                ->count(2)
                ->forCategory($electronics)
                ->electronics()
                ->withRealImages()
                ->outOfStock()
                ->create();
        }

        if ($adultProducts) {
            // Create Adult Personal Products
            Product::factory()
                ->count(5)
                ->forCategory($adultProducts)
                ->withRealImages()
                ->inStock()
                ->create();
        }
    }
}
