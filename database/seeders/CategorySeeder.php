<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Vehicles',
            'Property Rentals',
            'Home',
            'Gardens',
            'Electronics',
            'Clothing',
            'Accessories',
            'Hobbies',
            'Classifieds',
            'Entertainment',
            'Family',
            'Services',
        ];

        Category::factory(count($categories))->create();
    }
}
