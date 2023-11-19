<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PostItem\PostItemService;
use App\Http\Services\PostItem\GetAllPostItemService;
use App\Http\Services\PostItem\GetPostDetailsService;
use App\Http\Services\PostItem\GetTop3PostCategoryService;
use App\Http\Services\PostItem\GetRecentViewedPostService;
use App\Http\Services\PostItem\AddWishListService;
use App\Http\Services\MyStore\GetPostByUserIDService;
use App\Http\Services\MyStore\GetPostImagesByIDService;
use App\Http\Services\MyStore\GetWishlistImagesByUserIDService;
use App\Http\Services\MyStore\GetWishlistImagesByIDService;

class PostController extends Controller
{
    public function GetAllPostItem()
    {
        return GetAllPostItemService::GetAllPostItem();
    }
    public function PostItem(Request $request)
    {
        return PostItemService::PostItem($request);
        
    }
    public function GetTop3PostCategory()
    {
        return GetTop3PostCategoryService::GetTop3PostCategory();

    }
    public function GetPostDetails(Request $request)
    {
        return GetPostDetailsService::GetPostDetails($request);
    }
    public function GetRecentViewedPost(Request $request)
    {
        return GetRecentViewedPostService::GetRecentViewedPost($request);
    }
    public function AddWishList(Request $request)
    {
        return AddWishListService::AddWishList($request);
    }
    public function GetPostByUserID()
    {
        return GetPostByUserIDService::GetPostByUserID();
    }
    public function GetPostImagesByID(Request $request)
    {
        return GetPostImagesByIDService::GetPostImagesByID($request);
    }
    public function GetWishlistImagesByUserID()
    {
        return GetWishlistImagesByUserIDService::GetWishlistImagesByUserID();
    }
    public function GetWishlistImagesByID(Request $request)
    {
        return GetWishlistImagesByIDService::GetWishlistImagesByID($request);
    }

}
