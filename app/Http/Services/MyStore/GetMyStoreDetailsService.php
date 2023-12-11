<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GetMyStoreDetailsService
{
    public static function GetMyStoreDetails()
    {
        try {

            $user = Auth::user();
            $checkUser = User::with(['countPost', 'ratings', 'verification'])
                ->find($user->id);

            if ($checkUser) {
                $userData = [
                    'id' => $checkUser->id,
                    'fullname' => $checkUser->fullname,
                    'wallet' => $checkUser->credits_amount,
                    'profile_img' => $checkUser->profile_img ? $checkUser->profile_img : asset("uploads/default_profile.png"),
                    'total_post' => $checkUser->countPost ? $checkUser->countPost->count() : 0,
                    'total_ratings' => $checkUser->ratings ? $checkUser->ratings->count() : 0,
                    'is_verified' => $checkUser->verification?->status == 'Approved' ?? false,
                ];

                return response([
                    'status' => 'success',
                    'data' => $userData,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'data' => 'No Data Found',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
