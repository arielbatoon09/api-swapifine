<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Category\GetAllCategoryService;
use App\Http\Services\Category\PostCategoryService;
use App\Http\Services\Category\UpdateCategoryService;
use App\Http\Services\Category\DeleteCategoryService;

class CategoryController extends Controller
{
    public function GetAllCategory()
    {
        return GetAllCategoryService::GetAllCategory();
    }
    public function PostCategory(Request $request)
    {
        return PostCategoryService::PostCategory($request);
    }
    public function UpdateCategory(Request $request)
    {
        return UpdateCategoryService::UpdateCategory($request);
    }
    public function DeleteCategory(Request $request)
    {
        return DeleteCategoryService::DeleteCategory($request);
    }
}
