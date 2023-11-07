<?php

namespace App\Http\Services\Credits;

use Throwable;
use Illuminate\Http\Request;
use App\Models\PurchaseCredits;

class DeleteCheckoutService
{
    public static function DeleteCheckout(Request $request)
    {
        try {
            $checkoutSessionId = $request->checkout_session_id;
            PurchaseCredits::where("checkout_session_id", $checkoutSessionId)->delete();

            return response([
                'status' => 'success',
                'message' => 'Removed from checkout.',
            ]);

        } catch (Throwable $e) {
            return 'Error Catch' . $e->getMessage();
        }
    }
}