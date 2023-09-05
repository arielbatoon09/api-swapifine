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
            if(!empty($request->category)){
                    $getCategory = Category::where('category', $request->category)->first();
                    if(!$getCategory){
                        Category::create([
                            'category' => $request->input('category'),
                        ]);
                        return response([
                            'status' => 'success',
                            'message' => "Category created.",
                        ]);
                    }else{
                        return response([
                            'source' => 'categoryExists',
                            'status' => 'error',
                            'message' => 'category already in use.',
                        ]);
                    }
                }else{
                    return response([
                        'source' => 'category not valid',
                        'status' => 'error',
                        'message' => 'Enter valid category.',
                    ]);
                }
        } catch (Throwable $error){
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
            }else{
                return $categories;
            }
        } catch (Throwable $error) {
            return response([
                'source' => 'error',
                'message' => 'ERROR ' . $error
            ]);
        }
    }
}
