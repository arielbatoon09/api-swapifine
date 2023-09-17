<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;

class GetTopPostCategoryService
{
    public static function GetTopPostCategory(Request $request)
    {
        try {

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }

    }
}