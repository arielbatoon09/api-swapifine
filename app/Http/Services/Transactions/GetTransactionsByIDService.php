<?php

namespace App\Http\Services\Transactions;

use Throwable;
use App\Models\Transactions;
use Illuminate\Http\Request;

class GetTransactionsByIDService
{
    public static function GetTransactionsByID(Request $request)
    {
        try {
            $transactions = Transactions::with('inbox')->where("id", $request->id)->first();

            $transactionsData[] = [
                'id' => $transactions->id,
                'item_name' => $transactions->inbox->post->item_name,
                'delivery_address' => $transactions->delivery_address,
                'user_notes' => $transactions->user_notes,
                'transaction_date' => date('Y-m-d H:i:s', strtotime($transactions->created_at)),
                'updated_date' => date('Y-m-d H:i:s', strtotime($transactions->updated_at)),
            ];

            return response([
                'status' => 'success',
                'data' => $transactionsData,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch ' . $e->getMessage();
        }
    }
}