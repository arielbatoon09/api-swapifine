<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Post;

class UnlistItemService
{
    public static function UnlistItem(Request $request)
    {
        try {
            $post = Post::where('id', $request->id)->first();
            $post->update([
                'is_available' => 0
            ]);

            return response([
                'status' => 'success',
                'message' => 'Successfully unlisted the item.',
            ]);

        } catch (Throwable $e) {
            return "Error Catch: " . $e->getMessage();
        }
    }
}