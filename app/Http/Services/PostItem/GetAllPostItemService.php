<?php

namespace App\Http\Services\PostItem;

use Throwable;
use App\Models\Post;

class GetAllPostItemService
{
    public static function GetAllPostItem()
    {
        try {
            $postsWithImagesAndLocation = Post::with(['images', 'location'])
            ->where('is_available', 1)
            ->get();
        
        $postData = [];
        
        foreach ($postsWithImagesAndLocation as $post) {        
            $postData[] = [
                'id' => $post->id,
                'item_name' => $post->item_name,
                'fullname' => $post->user->fullname,
                'images' => $post->images,
                'category_name' => $post->category->category_name,
                'post_address' => $post->location->address,
                'post_latitude' => $post->location->latitude,
                'post_longitude' => $post->location->longitude,
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
