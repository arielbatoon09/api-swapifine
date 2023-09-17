<?php

namespace App\Http\Services\PostItem;

use Throwable;
use App\Models\Post;
// use App\Models\Image;

class GetAllPostItem
{
    public static function GetAllPostItem()
    {
        try {
            $postsWithImages = Post::with('images')->get();
            $postData = [];
            
            foreach ($postsWithImages as $post) {
            
                $postData[] = [
                    'item_name' => $post->item_name,
                    'fullname' => $post->user->fullname,
                    'images' => $post->images,
                ];
            }

            if($postData){
                return response([
                    'status' => 'success',
                    'data' => $postData,
                ]);
            } else{
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