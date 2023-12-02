<?php

namespace App\Http\Services\PostItem;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class AddWishListService
{
    public static function AddWishList(Request $request) 
    {
        try {
            $user = Auth::user();

            $checkWishlist = Wishlist::where('user_id', $user->id)
            ->where('post_item_id', $request->post_item_id)
            ->first();

            if (!$checkWishlist) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'post_item_id' => $request->post_item_id,
                ]);
    
                return response([
                    'status' => 'added',
                    'message' => "Added to wishlist.",
                ]);
            } else {
                $checkWishlist->delete();

                return response([
                    'status' => 'unlist',
                    'message' => "Unlisted to wishlist.",
                ]);
            }
            
        } catch (Throwable $e) {
            return 'Error Catch: '. $e->getMessage();
        }
    }
}