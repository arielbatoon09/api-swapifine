<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class GetWithdrawalByIDService
{
    public static function GetWithdrawalByID(Request $request)
    {
        try {
            $withdrawal = Withdrawal::where('id', $request->id)
                ->with('user')
                ->orderBy("created_at", "desc")
                ->first();

            if (!$withdrawal) {
                return response([
                    'status' => 'error',
                    'message' => 'Withdrawal Record not found',
                ]);
            }

            $data[] = [
                'id' => $withdrawal->id,
                'account_name' => $withdrawal->account_name,
                'account_number' => $withdrawal->account_number,
                'transfer_to' => $withdrawal->transfer_to,
                'amount' => $withdrawal->amount,
                'date_of_request' => date('Y-m-d H:i:s', strtotime($withdrawal->created_at)),
            ];

            return response([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return 'Error catch: ' . $e->getMessage();
        }
    }
}
