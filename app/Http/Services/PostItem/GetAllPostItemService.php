<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class GetAllPostItemService
{
    public static function GetAllPostItem()
    {
        try {
            $postsWithImagesAndLocation = Post::with(['images', 'location', 'wishlist'])
            ->where('is_available', 1)
            ->get();
        
        $postData = [];
        $user = Auth::user();
        
        foreach ($postsWithImagesAndLocation as $post) {      
            $added_user_wishlist = false; 
            
            if ($post->wishlist && $user) {
                if ($post->wishlist->user_id === $user->id && $post->wishlist->post_item_id === $post->id) {
                    $added_user_wishlist = true;
                }
            }

            $postData[] = [
                'id' => $post->id,
                'item_name' => $post->item_name,
                'fullname' => $post->user->fullname,
                'images' => $post->images,
                'category_name' => $post->category->category_name,
                'condition' => $post->condition,
                'item_for_type' => $post->item_for_type,
                'post_address' => $post->location->address,
                'post_latitude' => $post->location->latitude,
                'post_longitude' => $post->location->longitude,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'added_user_wishlist' => $added_user_wishlist,
            ];
        }

            if ($postData) {
                return response([
                    'status' => 'success',
                    'data' => $postData,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'data' => "No Data Found",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
