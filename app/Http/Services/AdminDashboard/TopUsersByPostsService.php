<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use App\Models\User;

class TopUsersByPostsService
{
    public static function TopUsersByPosts()
    {
        try {
            $users = User::withCount('post')
                ->orderByDesc('post_count')
                ->take(10)
                ->get();

            $usersData = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                    'total_post' => $user->post_count,
                ];
            });

            return response([
                'status' => 'success',
                'data' => $usersData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
