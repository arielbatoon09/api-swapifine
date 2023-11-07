<?php

namespace App\Http\Services\Transactions;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Transactions;

class GetAdditionalInformationService
{
    public static function GetAdditionalInformation(Request $request)
    {
        try {

            $transaction = Transactions::find($request->transaction_id);

            return response([
                'status' => 'success',
                'data' => $transaction,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: '. $e->getMessage();
        }
    }
}