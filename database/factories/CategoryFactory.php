<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Category::class;

     public function definition(): array
     {
         static $categories = [
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
     
         return [
             'category_name' => array_shift($categories),
         ];
     }     
}
