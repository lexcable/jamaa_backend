<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fresh Produce',
            'Bakery & Pastry',
            'Meat & Poultry',
            'Seafood',
            'Dairy & Eggs',
            'Frozen Foods',
            'Pantry & Dry Goods',
            'Beverages',
            'Snacks & Confectionery',
            'Household Supplies',
            'Personal Care',
            'Baby Products',
            'Pet Supplies',
            'Electronics',
            'Home & Kitchen',
            'Stationery & Office',
            'Fashion & Accessories',
            'Health & Wellness',
            'Cleaning Supplies',
            'Automotive Supplies',
            'Garden & Outdoor',
            'Sports & Fitness',
            'Toys & Games'
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
