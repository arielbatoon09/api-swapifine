<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class GetWithdrawalListByUserIDService
{
    public static function GetWithdrawalListByUserID()
    {
        try {
            $user = Auth::user();

            $withdrawals = Withdrawal::where('user_id', $user->id)
                ->with('user')
                ->orderBy("created_at", "desc")
                ->get();

            $withdrawalData = [];

            if ($withdrawals) {
                foreach ($withdrawals as $withdrawal) {
                    $withdrawalData[] = [
                        'id' => $withdrawal->id,
                        'fullname' => $withdrawal->user->fullname,
                        'transfer_to' => $withdrawal->transfer_to,
                        'amount' => $withdrawal->amount,
                        'status' => $withdrawal->status,
                        'date_of_request' => date('Y-m-d H:i:s', strtotime($withdrawal->created_at)),
                    ];
                }
            }

            return response([
                'status' => 'success',
                'data' => $withdrawalData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
