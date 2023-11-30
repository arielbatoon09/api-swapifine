<?php

namespace App\Http\Services\MyStore;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Ratings;

class GetRatingsByUserIDService
{
    public static function GetRatingsByUserID()
    {
        try {
            $user = Auth::user();
            $ratings = Ratings::with(['ratedBy'])
                ->where('rated_to_id', $user->id)
                ->get();

            $ratingsData = [];

            foreach ($ratings as $rating) {

                $ratingsData[] = [
                    'id' => $rating->id,
                    'rated_by_id' => $rating->rated_by_id,
                    'rated_by_fullname' => $rating->ratedBy->fullname,
                    'comment' => $rating->comment,
                    'scale_ratings' => $rating->scale_ratings,
                    'profile' => $rating->ratedBy->profile_img,
                    'rated_date' => date('F d, Y', strtotime($rating->created_at)),
                ];
            }

            if ($ratingsData) {
                return response([
                    'status' => 'success',
                    'data' => $ratingsData,
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
