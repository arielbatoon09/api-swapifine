<?php

namespace App\Http\Services\Category;

use Throwable;
use App\Models\Category;

class GetAllCategoryService
{
    public static function GetAllCategory()
    {
        try {
            $categories = Category::with('post')->get();

            $categoryData = [];
            
            foreach ($categories as $category) {
                $categoryData[$category->id] = [
                    'id' => $category->id,
                    'category_name' => $category->category_name,
                    'total_post' => $category->post->count(),
                    'created_date' => date('Y-m-d H:i:s', strtotime($category->created_at)),
                    'updated_at' => date('Y-m-d H:i:s', strtotime($category->updated_at)),
                ];
            }
            
            return response([
                'status' => 'success',
                'data' => $categoryData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
