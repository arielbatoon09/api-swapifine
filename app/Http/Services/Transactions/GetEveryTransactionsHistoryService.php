<?php

namespace App\Http\Services\Transactions;

use Throwable;
use App\Models\Transactions;

 class GetEveryTransactionsHistoryService
 {
    public static function GetEveryTransactionsHistory()
    {
        try {
            $transactions = Transactions::orderBy("created_at","desc")->get();

            return response([
                'status' => 'success',
                'data' => $transactions,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
 }