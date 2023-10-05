<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
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
                        'message' => "Category created.",
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
                    'source' => 'category not valid',
                    'status' => 'error',
                    'message' => 'Enter valid category.',
                ]);
            }
        } catch (Throwable $error) {
            response([
                'status' => 'error',
                'message' => 'ERROR' . $error,
            ]);
        }
    }

    public function CategoryList()
    {
        try {
            $categories = Category::all();
            if ($categories->isEmpty()) {
                return response([
                    'source' => 'CategoryNotFound',
                    'status' => 'error',
                    'message' => 'Unknown Category'
                ]);
            } else {
                return $categories;
            }
        } catch (Throwable $error) {
            return response([
                'source' => 'error',
                'message' => 'ERROR ' . $error
            ]);
        }
    }

    public function update(Request $request)
    {   
        try {
            if (!empty($request->category_name)) {
                $updateCategory = Category::where('category_name', $request->category_name)->first();
                if (!$updateCategory) {
                    $resource = Category::findOrFail($request->input('id'));
                    $resource->update([
                        'category_name' => $request->input('category_name'),
                    ]);
                    return response([
                        'status' => 'success',
                        'message' => "Category updated.",
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
                    'source' => 'category not valid',
                    'status' => 'error',
                    'message' => 'Enter valid category.',
                ]);
            }
        } catch (Throwable $error) {
            response([
                'resource' => 'error',
                'message' => 'ERROR' . $error
            ]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $deleteCategory = Category::find($request->id)->delete();

            if ($deleteCategory) {
                // Category deleted successfully.
                return response([
                    'status' => 'success',
                    'message' => "Category deleted.",
                ]);
            } else {
                return response([
                    'source' => 'error',
                    'status' => 'error',
                    'message' => 'Category could not be deleted.',
                ]);
            }
        } catch (Throwable $error) {
            // Handle other errors.
            return response([
                'source' => 'error',
                'status' => 'error',
                'message' => 'ERROR: ' . $error->getMessage(),
            ]);
        }
    }
}
