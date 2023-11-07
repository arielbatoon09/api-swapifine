<?php

namespace App\Http\Services\Credits;

use Throwable;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseCredits;

class CheckoutCreditsService
{
    private $currency;
    private $successUrl;
    private $refKey;

    private function __construct()
    {
        $this->currency = 'PHP';
        // $this->successUrl = env('BACKEND_URL') . '/api/checkout/completed/';
        $this->successUrl = env('SANCTUM_STATEFUL_DOMAINS');

        // Generate REF_KEY
        $randomNumber = mt_rand(1000, 9999);
        $stringPrefix = 'CREDITS';
        $this->refKey = 'REF_' . $stringPrefix . $randomNumber;
    }

    public static function checkoutCredits(Request $request)
    {
        try {
            $validationResult = self::validateCheckout($request);

            if ($validationResult === 'success') {
                $dataRes = self::processCheckout($request);
                $checkout_session_id = $dataRes['data']['id'];
                $reference_number = $dataRes['data']['attributes']['reference_number'];
                $checkout_url = $dataRes['data']['attributes']['checkout_url'];

                self::StoreCheckout($request, $checkout_session_id, $reference_number, $checkout_url);

                return response([
                    'status' => 'success',
                    'message' => 'Added to checkout.',
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'source' => $validationResult,
                    'message' => self::getValidationMessage($validationResult),
                ]);
            }
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }
    private static function StoreCheckout($request, $checkout_session_id, $reference_number, $checkout_url)
    {
        try {
            $userID = Auth::user()->id;
            $toUppercaseMOP = strtoupper($request->payment_method);

            $PurchaseCredits = new PurchaseCredits();

            $PurchaseCredits->create([
                'user_id' => $userID,
                'ref_key' => $reference_number,
                'checkout_session_id' => $checkout_session_id,
                'purchase_name' => $request->purchase_name,
                'description' => $request->description,
                'payment_method' => $toUppercaseMOP,
                'checkout_url' => $checkout_url,
                'amount' => $request->amount,
                'status' => 'Pending',
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }

    private static function processCheckout($request)
    {
        try {
            $instance = new self();
            $client = new \GuzzleHttp\Client();
            $calAmount = null;

            switch ($request->payment_method) {
                case 'gcash':
                    $calAmount = $request->amount + ($request->amount * 0.025);
                    break;
                case 'paymaya':
                    $calAmount = $request->amount + ($request->amount * 0.020);
                    break;
                case 'grab_pay':
                    $calAmount = $request->amount + ($request->amount * 0.022);
                    break;
                case 'card':
                    $calAmount = $request->amount + ($request->amount * 0.035) + 15;
                    break;
            }

            $amount = (int)($calAmount * 100);

            $requestData = [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => false,
                        'show_description' => true,
                        'show_line_items' => true,
                        'line_items' => [
                            [
                                'currency' => $instance->currency,
                                'amount' => $amount,
                                'description' => $request->description,
                                'name' => $request->purchase_name,
                                'quantity' => 1,
                            ]
                        ],
                        'payment_method_types' => [$request->payment_method],
                        'reference_number' => $instance->refKey,
                        'success_url' => $instance->successUrl,
                        'description' => $request->description,
                    ]
                ]
            ];

            $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
                'body' => json_encode($requestData),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'accept' => 'application/json',
                    'authorization' => env('PAYMONGO_AUTH_KEY'),
                ],
            ]);

            return json_decode($response->getBody(), true);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }

    private static function validateCheckout($request)
    {
        try {
            if (!empty($request->amount) && !empty($request->purchase_name) && !empty($request->description) && !empty($request->payment_method)) {
                if (filter_var($request->amount, FILTER_VALIDATE_INT) !== false) {
                    if ($request->amount >= 50 && $request->amount <= 5000) {
                        return 'success';
                    } else {
                        return 'isNotMeet';
                    }
                } else {
                    return 'isInvalid';
                }
            } else {
                return 'isEmpty';
            }
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }

    private static function getValidationMessage($validationResult)
    {
        $messages = [
            'isEmpty' => 'Please fill out this field.',
            'isInvalid' => 'This field only accepts a valid number.',
            'isNotMeet' => 'Enter another value.',
        ];

        return $messages[$validationResult] ?? 'Unknown error';
    }
}
