<?php

namespace Database\Seeders;

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
            'Others',
        ];

        Category::factory(count($categories))->create();
    }
}
