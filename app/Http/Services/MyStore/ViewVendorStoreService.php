<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Ratings;

class ViewVendorStoreService
{
    public static function ViewVendorStore(Request $request)
    {
        try {
            $checkUser = User::with(['post', 'ratings', 'verification'])
            ->find($request->id);
        
            $checkPost = Post::where('user_id', $request->id)
            ->where('is_available', 1)
            ->where('user_id', $request->id)
            ->get();

            $postsWithImages = Post::with(['images'])
            ->where('is_available', 1)
            ->where('user_id', $request->id)
            ->get();

            $checkRatings = Ratings::with(['ratedBy'])
            ->where('rated_to_id', $request->id)
            ->get();

            $userData[] = [
                'id' => $checkUser->id,
                'fullname' => $checkUser->fullname,
                'profile_img' => $checkUser->profile_img ? $checkUser->profile_img : asset("uploads/default_profile.png"),
                'total_post' => $checkPost ? $checkPost->count() : 0,
                'total_ratings' => $checkUser->ratings ? $checkUser->ratings->count() : 0,
                'is_verified' => $checkUser->verification?->status == 'Approved' ?? false,
            ];

            $postData = [];
            foreach ($postsWithImages as $post) {
                $postData[] = [
                    'id' => $post->id,
                    'item_name' => $post->item_name,
                    'images' => $post->images,
                    'thumbnail' => $post->images->first()->img_file_path,
                ];
            }

            $ratingsData = [];
            foreach ($checkRatings as $rating) {

                $ratingsData[] = [
                    'id' => $rating->id,
                    'rated_by_id' => $rating->rated_by_id,
                    'rated_by_fullname' => $rating->ratedBy->fullname,
                    'comment' => $rating->comment,
                    'scale_ratings' => $rating->scale_ratings,
                    'profile' => $rating->ratedBy->profile_img ? $rating->ratedBy->profile_img : asset("uploads/default_profile.png"),
                    'rated_date' => date('F d, Y', strtotime($rating->created_at)),
                ];
            }

            return response([
                'status' => 'success',
                'userData' => $userData,
                'postData' => $postData,
                'ratingsData' => $ratingsData,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}