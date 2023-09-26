<?php

namespace App\Http\Services\Category;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Category;

class PostCategoryService
{
    public static function PostCategory(Request $request)
    {
        try {
            if (!empty($request->category_name)) {
                $getCategory = Category::where('category_name', $request->category_name)->first();
                if (!$getCategory) {
                    Category::create([
                        'category_name' => $request->input('category_name'),
                    ]);
                    return response([
                        'status' => 'success',
                        'message' => "Category created!",
                    ]);
                } else {
                    return response([
                        'source' => 'categoryExists',
                        'status' => 'error',
                        'message' => 'category already in use.',
                    ]);
                }
            } else {
                return response([
                    'source' => 'notValid',
                    'status' => 'error',
                    'message' => 'Enter valid category.',
                ]);
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage(); 
        }
    }
}