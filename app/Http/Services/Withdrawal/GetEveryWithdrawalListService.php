<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use App\Models\Withdrawal;

class GetEveryWithdrawalListService
{
    public static function GetEveryWithdrawalList()
    {
        try {

            $withdrawal = Withdrawal::with('user')->orderBy("created_at", "desc")->get();
            $withdrawalData = [];

            foreach ($withdrawal as $withdrawals) {
                $withdrawalData[] = [
                    'id' => $withdrawals->id,
                    'fullname' => $withdrawals->user->fullname,
                    'transfer_to' => $withdrawals->transfer_to,
                    'amount' => $withdrawals->amount,
                    'status' => $withdrawals->status,
                    'date_of_request' => date('Y-m-d H:i:s', strtotime($withdrawals->created_at)),
                ];
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