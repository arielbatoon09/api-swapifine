<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Transactions;

class AdditionalInformationService
{
    public static function AdditionalInformation(Request $request)
    {
        try {
            $transaction = Transactions::find($request->transaction_id);

            if (!empty($request->payment_method) && !empty($request->delivery_address) && !empty($request->user_notes)) {
                if ($request->payment_method == "credits") {
                    if ($transaction) {
                        $user = $transaction->user;
                        $inbox = $transaction->inbox;
                        $post = $inbox->post;
                        $itemCashValue = $post->item_cash_value;

                        if ($user && ($user->credits_amount !== null && $user->credits_amount !== 0)) {
                            if ($user->credits_amount >= $itemCashValue) {

                                // Sufficient credits to proceed with the transaction
                                $transaction->update([
                                    'payment_method' => $request->payment_method,
                                    'delivery_address' => $request->delivery_address,
                                    'user_notes' => $request->user_notes,
                                    'status' => 'To Deliver',
                                ]);

                                return response([
                                    'status' => 'success',
                                    'message' => 'Sent the provided details.',
                                ]);
                            } else {
                                return response([
                                    'status' => 'error',
                                    'message' => 'Not enough wallet credits.',
                                ]);
                            }
                        } else {
                            return response([
                                'status' => 'error',
                                'message' => 'Buy wallet credits first!',
                            ]);
                        }
                    }
                } else {
                    $transaction->update([
                        'payment_method' => $request->payment_method,
                        'delivery_address' => $request->delivery_address,
                        'user_notes' => $request->user_notes,
                        'status' => 'To Deliver',
                    ]);

                    return response([
                        'status' => 'success',
                        'message' => 'Sent the provided details.',
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