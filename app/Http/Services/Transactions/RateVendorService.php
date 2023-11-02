<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Ratings;
use App\Models\Transactions;
use Illuminate\Support\Facades\Auth;

class RateVendorService
{
    public static function RateVendor(Request $request)
    {
        try {

            if (!empty($request->rated_to_id) && !empty($request->scale_ratings) && !empty($request->comment)) {

                // Create a new Ratings record
                $ratings = Ratings::create([
                    'rated_by_id' => Auth::user()->id,
                    'rated_to_id' => $request->rated_to_id,
                    'scale_ratings' => $request->scale_ratings,
                    'comment' => $request->comment,
                ]);

                if ($ratings) {
                    // Update the Transactions record
                    Transactions::where('id', $request->transaction_id)->update(['status' => 'Rated']);

                    return response([
                        'status' => 'success',
                        'message' => 'Thank you for rating the vendor.',
                    ]);
                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Failed to create the rating record.',
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'The field should not be empty!',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
