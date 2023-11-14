<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Post;

 class GetPostImagesByIDService
 {
    public static function GetPostImagesByID(Request $request)
    {
        try {

            $postId = $request->id;

            // Use find to get a single post by id
            $post = Post::with('images')
                ->where('id', $postId)
                ->where('is_available', 1)
                ->first();
        
            // Check if the post exists
            if (!$post) {
                return response([
                    'status' => 'error',
                    'message' => 'Post not found',
                ], 404);
            }
        
            $postImageData = [];
        
            foreach ($post->images as $image) {
                $postImageData[] = [
                    'images' => $image->img_file_path,
                    'caption' => $post->item_name,
                ];
            }
        
            return response([
                'status' => 'success',
                'data' => $postImageData,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
 }