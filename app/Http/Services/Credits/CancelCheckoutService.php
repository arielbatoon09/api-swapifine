<?php

namespace App\Http\Services\Credits;

use Throwable;
use Illuminate\Http\Request;
use App\Models\PurchaseCredits;

class CancelCheckoutService
{
    public static function CancelCheckout(Request $request)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $checkoutSessionId = $request->checkout_session_id;

            PurchaseCredits::where("checkout_session_id", $checkoutSessionId)->update([
                'status' => 'Cancelled',
            ]);

            $response = $client->request('POST', "https://api.paymongo.com/v1/checkout_sessions/{$request->checkout_session_id}/expire", [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => env('PAYMONGO_AUTH_KEY'),
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
