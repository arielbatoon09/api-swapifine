<?php

namespace App\Http\Services\Category;

use Throwable;
use App\Models\Category;

class GetAllCategoryService
{
    public static function GetAllCategory()
    {
        try {
            $categoryData = Category::all();
            if ($categoryData->isEmpty()) {
                return response([
                    'status' => 'error',
                    'message' => 'Data not found!',
                ]);
            } else {
                return response([
                    'status' => 'success',
                    'data' => $categoryData,
                ]);
            }

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage(); 
        }
    }
}
