<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            'Electronics',
            'Fashion',
            'Home Appliances',
            'Sports',
        ])->map(function ($name) {
            return Category::create(['name' => $name]);
        });

        Product::factory(10)->create()->each(function ($product) use ($categories) {
            $randomCategories = $categories->random(rand(1, 3));
            $product->categories()->attach($randomCategories);
        });
    }
}
