<?php

namespace App\Http\Services\AdminDashboard;

use Throwable;
use App\Models\User;
use App\Models\Verification;
use App\Models\Post;

class TotalNumbersService
{
    public static function TotalNumbers()
    {
        try {
            
            $userCount = User::count();
            $verificationCount = Verification::where('status', 'Pending')->count();
            $postCount = Post::where('is_available', 1)->count();

            $dataCounts[] = [
                'userCount' => $userCount,
                'verificationCount' => $verificationCount,
                'postCount' => $postCount,
            ];

            return response([
                'status' => 'success',
                'data' => $dataCounts,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}