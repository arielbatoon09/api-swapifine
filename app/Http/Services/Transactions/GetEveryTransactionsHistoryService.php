<?php

namespace App\Http\Services\Transactions;

use Throwable;
use App\Models\Transactions;

class GetEveryTransactionsHistoryService
{
    public static function GetEveryTransactionsHistory()
    {
        try {
            $transactions = Transactions::with('vendor', 'buyer_user', 'inbox')->orderBy("created_at", "desc")->get();
            $transactionsData = [];

            foreach ($transactions as $transaction) {
                $paymentMethod = null;
                switch ($transaction->payment_method) {
                    case 'cod':
                        $paymentMethod = 'Cash on Delivery';
                        break;
                    case 'ewallet':
                        $paymentMethod = 'E-Wallet';
                        break;
                    case 'credits':
                        $paymentMethod = 'Swapifine Credits';
                        break;
                    default:
                        $paymentMethod = $transaction->payment_method;
                }
                $transactionsData[] = [
                    'id' => $transaction->id,
                    'vendor_name' => $transaction->vendor->fullname,
                    'buyer_name' => $transaction->buyer_user->fullname,
                    'payment_method' => $paymentMethod,
                    'item_name' => $transaction->inbox->post->item_name,
                    'transaction_type' => $transaction->inbox->post->item_for_type,
                    'amount' => $transaction->inbox->post->item_cash_value,
                    'transaction_date' => date('Y-m-d H:i:s', strtotime($transaction->created_at)),
                    'updated_date' => date('Y-m-d H:i:s', strtotime($transaction->created_at)),
                ];
            }

            return response([
                'status' => 'success',
                'data' => $transactionsData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
