<?php

namespace App\Http\Services\Credits;

use Throwable;
use App\Models\PurchaseCredits;
use Illuminate\Support\Facades\Auth;

class GetAllCheckoutCreditsService
{
    public static function GetAllCheckoutCredits()
    {
        try {
            $userID = Auth::user()->id;

            $purchaseCredits = PurchaseCredits::where("user_id", $userID)->get();

            return response([
                'status' => 'success',
                'data' => $purchaseCredits,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: '. $e->getMessage();
        }
    }
}