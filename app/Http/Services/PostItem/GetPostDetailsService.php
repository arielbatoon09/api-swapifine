<?php

namespace App\Http\Services\PostItem;

use Illuminate\Support\Str;
use Throwable;
use Illuminate\Http\Request;
use App\Models\Post;

class GetPostDetailsService
{
    public static function GetPostDetails(Request $request)
    {
        try {
            $postId = $request->id;

            if (Str::startsWith($postId, 'REF_ITEM')) {
                $postWithImages = Post::with('images')->where('item_key', $postId)->first();
            } else {
                $postWithImages = Post::with('images')->find($postId);
            }

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
                    'post_address' => $postWithImages->location->address,
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