<?php

namespace App\Http\Services\PostItem;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Throwable;

class GetTop3PostCategoryService
{
    public static function GetTop3PostCategory()
    {
        try {
            // Get the top 3 category IDs based on the number of posts
            $topCategoryIds = Post::select('category_id')
                ->selectRaw('COUNT(*) as post_count')
                ->where('is_available', 1)
                ->groupBy('category_id')
                ->orderByDesc('post_count')
                ->limit(3)
                ->pluck('category_id');

            if ($topCategoryIds->isEmpty()) {
                return response([
                    'status' => 'error',
                    'data' => "No Data Found",
                ]);
            }

            // Retrieve posts that belong to the top 3 category IDs using Eloquent
            $postsWithImages = Post::with(['images', 'user', 'category','location', 'wishlist'])
                ->where('is_available', 1)
                ->whereIn('category_id', $topCategoryIds)
                ->get();

            // Group the post data by category_id and include category_name
            $groupedData = [];
            $user = Auth::user();

            foreach ($postsWithImages as $post) {
                $category_id = $post->category_id;
                if (!isset($groupedData[$category_id])) {
                    $groupedData[$category_id] = [
                        'category_name' => $post->category->category_name,
                        'posts' => [],
                    ];
                }

                // Wishlist check
                $added_user_wishlist = false; 
            
                if ($post->wishlist && $user) {
                    if ($post->wishlist->user_id === $user->id && $post->wishlist->post_item_id === $post->id) {
                        $added_user_wishlist = true;
                    }
                }

                // Limit the number of posts per category to less than 5
                if (count($groupedData[$category_id]['posts']) < 5) {
                    $groupedData[$category_id]['posts'][] = [
                        'id' => $post->id,
                        'item_name' => $post->item_name,
                        'fullname' => $post->user->fullname,
                        'vendor_profile' => $post->user->profile_img ? $post->user->profile_img : asset("uploads/default_profile.png"),
                        'images' => $post->images,
                        'category_name' => $post->category->category_name,
                        'post_address' => $post->location->address,
                        'post_latitude' => $post->location->latitude,
                        'post_longitude' => $post->location->longitude,
                        'added_user_wishlist' => $added_user_wishlist,
                    ];
                }
            }

            // Sort the grouped data by the number of posts in descending order
            usort($groupedData, function ($a, $b) {
                return count($b['posts']) - count($a['posts']);
            });

            return response([
                'status' => 'success',
                'data' => $groupedData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}