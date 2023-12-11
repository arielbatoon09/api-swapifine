<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Post;

class SearchAutoCompleteService
{
    public static function SearchAutoComplete(Request $request)
    {
        try {
            

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}

