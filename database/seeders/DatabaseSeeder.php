<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Example categories data
        $categories = [
            [
                'name' => 'Men',
            ],
            [
                'name' => 'Women',
            ],
            [
                'name' => 'Gadget',
            ],
            [
                'name' => 'Food',
            ],
        ];
        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name']
            ]);
        }

        // Example categories to be associated with the product
        $categoryIds = Category::pluck('id')->toArray(); // Get all category IDs

        // Example product data
        $products = [
            [
                'title' => 'Digital Camera',
                'image' => 'products/product-1.jpg',
                'categories' => $categoryIds, // Assign all categories
                'features' => ['Feature 1', 'Feature 2', 'Feature 3'], // Array of features
            ],
            [
                'title' => 'Lighter',
                'image' => 'products/product-2.jpg',
                'categories' => [1, 2, 3], // Specific categories
                'features' => ['Feature A', 'Feature B'], // Array of features
            ],
            [
                'title' => 'Liquid Milk',
                'image' => 'products/product-3.jpg',
                'categories' => [4], // Specific categories
                'features' => ['Feature New', 'Feature Old'], // Array of features
            ],
            [
                'title' => 'I Phone',
                'image' => 'products/product-4.jpg',
                'categories' => [3, 2], // Specific categories
                'features' => ['Feature Latest', 'Feature Test'], // Array of features
            ],
            [
                'title' => 'Ice Cream',
                'image' => 'products/product-5.jpg',
                'categories' => [1, 2, 3], // Specific categories
                'features' => ['Feature Another', 'Feature Example'], // Array of features
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'title' => $productData['title'],
                'image' => $productData['image'],
            ]);

            $product->categories()->sync($productData['categories']);

            foreach ($productData['features'] as $feature) {
                $product->features()->create(['description' => $feature]);
            }
        }
    }
}
