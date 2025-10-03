<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Electronic devices, gadgets, and accessories for modern living.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion and apparel for all seasons and occasions.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Educational, entertainment, and reference books.',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Home',
                'slug' => 'home',
                'description' => 'Home appliances, furniture, and household items.',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment, fitness gear, and outdoor activities.',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
