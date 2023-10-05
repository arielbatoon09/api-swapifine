<?php

namespace App\Http\Services\Category;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Category;

class UpdateCategoryService
{
    public static function UpdateCategory(Request $request)
    {
        try {
            if (!empty($request->category_name)) {
                $updateCategory = Category::where('category_name', $request->id)->first();

                if (!$updateCategory) {
                    $resource = Category::findOrFail($request->id);
                    $resource->update([
                        'category_name' => $request->input('category_name'),
                    ]);
                    return response([
                        'status' => 'success',
                        'message' => "Category updated!",
                    ]);
                } else {
                    return response([
                        'source' => 'categoryExist',
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
