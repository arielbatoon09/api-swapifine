<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Withdrawal;

class UpdateWithdrawalStatusService
{
    public static function UpdateWithdrawalStatus(Request $request)
    {
        try {
            $withdrawal = Withdrawal::where('id', $request->id)->first();

            if (!empty($request->status)) {
                $status = in_array($request->status, ["Cancelled", "Rejected", "Completed"]) ? $request->status : null;

                $withdrawal->status = $status;
                $withdrawal->save();

                return response([
                    'status' => 'success',
                    'message' => 'You have updated the status to ' . $status,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Not found withdrawal status request',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
