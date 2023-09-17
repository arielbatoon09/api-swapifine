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
                    'item_price' => $postWithImages->item_price,
                    'item_quantity' => $postWithImages->item_quantity,
                    'condition' => $postWithImages->condition,
                    'item_for_type' => $postWithImages->delivery_type,
                    'payment_type' => $postWithImages->payment_type,
                    'is_available' => $postWithImages->is_available,
                    'images' => $postWithImages->images,
                ];

                return $postData;
            } else {
                // Handle the case where the post with the given ID is not found
                return $postData = [];
            }


        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage(); 
        }
    }
}