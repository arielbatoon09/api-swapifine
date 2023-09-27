<?php

namespace App\Http\Services\PostItem;

use App\Models\Post;
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
            $postsWithImages = Post::with(['images', 'user', 'category'])
                ->where('is_available', 1)
                ->whereIn('category_id', $topCategoryIds)
                ->get();

            // Group the post data by category_id and include category_name
            $groupedData = [];
            foreach ($postsWithImages as $post) {
                $category_id = $post->category_id;
                if (!isset($groupedData[$category_id])) {
                    $groupedData[$category_id] = [
                        'category_name' => $post->category->category_name,
                        'posts' => [],
                    ];
                }

                // Limit the number of posts per category to less than 5
                if (count($groupedData[$category_id]['posts']) < 5) {
                    $groupedData[$category_id]['posts'][] = [
                        'id' => $post->id,
                        'item_name' => $post->item_name,
                        'fullname' => $post->user->fullname,
                        'images' => $post->images,
                        'category_name' => $post->category->category_name,
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