<?php

namespace App\Http\Services\PostItem;

use Illuminate\Http\Request;
use App\Models\Post;
use Throwable;

class GetRecentViewedPostService
{
    public static function GetRecentViewedPost(Request $request)
    {
        try {
            $inputData = $request->id;
            

            if (is_array($inputData)) {
                $postIds = array_values(array_unique($inputData));
            } elseif (is_string($inputData)) {
                // Remove square brackets and spaces, then split by commas
                $postIds = array_values(array_unique(explode(',', preg_replace('/[\[\]\s]/', '', $inputData))));
            }

            if (!empty($postIds)) {
                $postsWithImages = Post::with('images', 'location', 'wishlist')
                    ->whereIn('id', $postIds)
                    ->get();


                if ($postsWithImages->isNotEmpty()) {
                    $postData = $postsWithImages->map(function ($post) {

                        return [
                            'id' => $post->id,
                            'item_name' => $post->item_name,
                            'fullname' => $post->user->fullname,
                            'images' => $post->images,
                            'category_name' => $post->category->category_name,
                            'post_address' => $post->location->address,
                            'post_latitude' => $post->location->latitude,
                            'post_longitude' => $post->location->longitude,
                        ];
                    });

                    return response([
                        'status' => 'success',
                        'data' => $postData,
                    ]);
                }
            }

            return response([
                'status' => 'error',
                'message' => 'Data not found!',
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
