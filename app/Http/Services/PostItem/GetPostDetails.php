<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Post;

class GetPostDetails
{
    public static function GetPostDetails(Request $request)
    {
        try {
            $postId = $request->id;
            $postWithImages = Post::with('images')->find($postId);

            if ($postWithImages) {
                $postData = [
                    'id' => $postWithImages->id,
                    'user_id' => $postWithImages->user->id,
                    'fullname' => $postWithImages->user->fullname,
                    'category_name' => $postWithImages->category->category_name,
                    'item_name' => $postWithImages->item_name,
                    'item_description' => $postWithImages->item_description,
                    'item_for_type' => $postWithImages->item_for_type,
                    'item_cash_value' => $postWithImages->item_cash_value,
                    'item_stocks' => $postWithImages->item_stocks,
                    'condition' => $postWithImages->condition,
                    'is_available' => $postWithImages->is_available,
                    'images' => $postWithImages->images,
                ];

                return response([
                    'status' => 'success',
                    'data' => $postData,
                ]);

            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Data not found!',
                ]);
            }


        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage(); 
        }
    }
}