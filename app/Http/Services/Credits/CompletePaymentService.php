<?php

namespace App\Http\Services\Credits;

use Throwable;
use App\Models\PurchaseCredits;
use App\Models\User;
use Illuminate\Http\Request;

class CompletePaymentService
{
    public static function CompletePayment(Request $request)
    {
        try {

            $client = new \GuzzleHttp\Client();

            $response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $request->checkout_session_id, [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => env('PAYMONGO_AUTH_KEY'),
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $payments = $data['data']['attributes']['payments'];

            if (!empty($payments)) {

                if ($payments[0]['attributes']['status'] == 'paid') {
                    // Retrieve the PurchaseCredits record using the checkout_session_id
                    $purchaseCredits = PurchaseCredits::where('checkout_session_id', $request->checkout_session_id)->first();

                    if ($purchaseCredits) {
                        $user = User::find($purchaseCredits->user_id);

                        // Update the User table by adding the amount to the credits_amount column
                        if ($user) {
                            $user->increment('credits_amount', $purchaseCredits->amount);

                            // Update the PurchaseCredits record status to 'Paid'
                            $purchaseCredits->update(['status' => 'Paid']);

                            return response([
                                'status' => 'success',
                                'message' => 'Paid Successfully',
                            ]);
                        }
                    }
                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Unpaid Payment.',
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Either not found checkout_session or unpaid.',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
