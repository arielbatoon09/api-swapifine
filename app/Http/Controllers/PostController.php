<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PostItem\PostItemService;
use App\Http\Services\PostItem\GetAllPostItemService;
use App\Http\Services\PostItem\GetPostDetailsService;
use App\Http\Services\PostItem\GetTop3PostCategoryService;

class PostController extends Controller
{
    
    public function PostItem(Request $request)
    {
        return PostItemService::PostItem($request);
        
    }
    public function GetAllPostItem()
    {
        return GetAllPostItemService::GetAllPostItem();
    }
    public function GetTop3PostCategory()
    {
        return GetTop3PostCategoryService::GetTop3PostCategory();

    }
    public function GetPostDetails(Request $request)
    {
        return GetPostDetailsService::GetPostDetails($request);
    }

}
