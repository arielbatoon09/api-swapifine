<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\PostItem\PostItemService;
use App\Http\Services\PostItem\GetAllPostItem;

class PostController extends Controller
{
    
    public function PostItem(Request $request)
    {
        return PostItemService::PostItem($request);
        
    }

    public function GetAllPostItem()
    {
        return GetAllPostItem::GetAllPostItem();
    }

}
