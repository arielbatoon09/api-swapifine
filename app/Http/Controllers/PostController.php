<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PostItem\PostItem;
use App\Http\Services\PostItem\GetAllPostItem;
use App\Http\Services\PostItem\GetPostDetails;

class PostController extends Controller
{
    
    public function PostItem(Request $request)
    {
        return PostItem::PostItem($request);
        
    }
    public function GetAllPostItem()
    {
        return GetAllPostItem::GetAllPostItem();
    }
    public function GetPostDetails(Request $request)
    {
        return GetPostDetails::GetPostDetails($request);
    }

}
