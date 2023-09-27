<?php

namespace App\Http\Services\Category;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Category;

class DeleteCategoryService
{
    public static function DeleteCategory(Request $request)
    {
        try {
            $deleteCategory = Category::find($request->id)->delete();

            if ($deleteCategory) {
                return response([
                    'status' => 'success',
                    'message' => "Category deleted!",
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Category could not be deleted.',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }
}
