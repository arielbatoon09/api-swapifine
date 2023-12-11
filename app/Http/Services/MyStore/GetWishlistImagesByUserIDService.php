<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class GetWishlistImagesByUserIDService
{
    public static function GetWishlistImagesByUserID()
    {
        try {

            $user = Auth::user();
            $wishlistWithImages = Wishlist::with(['post'])
                ->where('user_id', $user->id)
                ->get();

            $wishlistData = [];      

            foreach ($wishlistWithImages as $wishlist) {
                $wishlistData[] = [
                    'id' => $wishlist->id,
                    'item_name' => $wishlist->post->item_name,
                    'thumbnail' => $wishlist->post->images->first()->img_file_path,
                ];
            }

            if ($wishlistData) {
                return response([
                    'status' => 'success',
                    'data' => $wishlistData,
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
