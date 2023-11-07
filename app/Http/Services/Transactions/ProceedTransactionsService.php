<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\User;

class ProceedTransactionsService
{
    public static function ProceedTransactions(Request $request)
    {
        try {
            $transaction = Transactions::find($request->transaction_id);

            if ($transaction) {
                $status = $request->status;
                $validStatuses = ['Requirements', 'To Deliver', 'Completed', 'To Review', 'Cancelled'];

                if (in_array($status, $validStatuses)) {
                    if ($request->status === 'Completed') {
                        $user = $transaction->user;
                        $inbox = $transaction->inbox;
                        $post = $inbox->post;
                        $itemCashValue = $post->item_cash_value;

                        if ($transaction->payment_method === 'credits') {

                            if ($user && $user->credits_amount !== null && $user->credits_amount >= $itemCashValue) {
                                // Deduct the $itemCashValue from the user's credits_amount
                                $user->decrement('credits_amount', $itemCashValue);

                                // Determine the vendor's user_id using the vendor_id
                                $vendorId = $transaction->vendor_id;

                                // Retrieve the vendor user
                                $vendor = User::find($vendorId);

                                if ($vendor) {
                                    // Calculate the 2% deduction
                                    $vendorDeduction = $itemCashValue * 0.02;

                                    // Add the deducted amount to the vendor's credits_amount
                                    $vendor->increment('credits_amount', $itemCashValue - $vendorDeduction);


                                    // Deduct 2% from the vendor's credits_amount
                                    $vendor->decrement('credits_amount', $vendorDeduction);

                                    // Update the vendor's credits_amount
                                    $vendor->save();
                                }

                                // Update the user's credits_amount
                                $user->save();

                                // Update the transaction status
                                $transaction->update(['status' => $status]);

                                return response([
                                    'status' => 'success',
                                    'message' => "Proceed to $status.",
                                ]);
                            } else {
                                return response([
                                    'status' => 'error',
                                    'message' => 'Not enough wallet credits.',
                                ]);
                            }
                        } else {
                            // If not Credits MOP - just update right away
                            $transaction->update(['status' => $status]);

                            return response([
                                'status' => 'success',
                                'message' => "Proceed to $status.",
                            ]);
                        }
                    } else {
                        // If not Completed status - just update right away
                        $transaction->update(['status' => $status]);

                        return response([
                            'status' => 'success',
                            'message' => "Proceed to $status.",
                        ]);
                    }
                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Invalid status provided.',
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Transaction not found.',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
