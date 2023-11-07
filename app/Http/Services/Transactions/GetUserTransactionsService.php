<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Transactions;

class GetUserTransactionsService
{
    public static function GetUserTransactions()
    {
        try {
            $transactions = Transactions::with('user', 'inbox', 'buyer_user')
            ->where(function ($query) {
                $user_id = Auth::user()->id;
                $query->where('user_id', $user_id)
                    ->orWhere('vendor_id', $user_id);
            })
            ->get();
        
        $data = $transactions->map(function ($transaction) {
            return [
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->user_id,
                'vendor_id' => $transaction->vendor_id,
                'vendor_name' => $transaction->inbox->post->user->fullname,
                'buyer_name' => $transaction->inbox->from_user->fullname,
                'msg_inbox_key' => $transaction->msg_inbox_key,
                'payment_method' => $transaction->payment_method,
                'delivery_address' => $transaction->delivery_address,
                'user_notes' => $transaction->user_notes,
                'post_item_id' => $transaction->inbox->post->id,
                'post_item_key' => $transaction->inbox->post->item_key,
                'item_name' => $transaction->inbox->post->item_name,
                'category_name' => $transaction->inbox->post->category->category_name,
                'cash_value' => $transaction->inbox->post->item_cash_value,
                'thumbnail' => $transaction->inbox->post->images[0]->img_file_path,
                'status' => $transaction->status,
            ];
        });
        
        return response([
            'status' => 'success',
            'data' => $data->all(),
        ]);

        } catch (Throwable $e) {
            return 'Error Catch. ' . $e->getMessage();
        }
    }
}
