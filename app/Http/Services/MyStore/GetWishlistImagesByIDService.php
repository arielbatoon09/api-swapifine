<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class GetWishlistImagesByIDService
{
    public static function GetWishlistImagesByID(Request $request)
    {
        try {
            $wishlistId = $request->id;

            $wishlist = Wishlist::with('post')
                ->where('id', $wishlistId)
                ->first();

            // Check if the post exists
            if (!$wishlist) {
                return response([
                    'status' => 'error',
                    'message' => 'Wishlist not found',
                ], 404);
            }

            $postImageData = [];

            foreach ($wishlist->post->images as $image) {
                $postImageData[] = [
                    'images' => $image->img_file_path,
                    'caption' => $wishlist->post->item_name,
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
