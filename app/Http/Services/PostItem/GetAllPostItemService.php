<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Wishlist;

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

            $wishlist = Wishlist::with(['post'])
            ->where('post_item_id', $post->id)
            ->get();
            
            $added_user_wishlist = false;

            foreach ($wishlist as $item) {
                if ($post->id === $item->post_item_id && $user->id === $item->user_id) {
                    $added_user_wishlist = true;
                    break;
                }
            }


            $postData[] = [
                'id' => $post->id,
                'item_name' => $post->item_name,
                'fullname' => $post->user->fullname,
                'user_id' => $post->user->id,
                'vendor_profile' => $post->user->profile_img ? $post->user->profile_img : asset("uploads/default_profile.png"),
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
