<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class GetPostByUserIDService
{
    public static function GetPostByUserID()
    {
        try {
            $user = Auth::user();
            $postsWithImages = Post::with(['images'])
                ->where('is_available', 1)
                ->where('user_id', $user->id)
                ->get();

            $postData = [];

            foreach ($postsWithImages as $post) {
                $thumbnail = null;

                $postData[] = [
                    'id' => $post->id,
                    'item_name' => $post->item_name,
                    'images' => $post->images,
                    'thumbnail' => $post->images->first()->img_file_path,
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
