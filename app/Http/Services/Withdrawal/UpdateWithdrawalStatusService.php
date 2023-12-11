<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;

class UpdateWithdrawalStatusService
{
    public static function UpdateWithdrawalStatus(Request $request)
    {
        try {
            $withdrawal = Withdrawal::where('id', $request->id)->first();
            $checkUser = User::find($withdrawal->user_id);
            if (!empty($request->status)) {
                $validStatuses = ["Cancelled", "Rejected", "Completed", "Delete"];

                if (in_array($request->status, $validStatuses)) {
                    // Set the status
                    $withdrawal->status = $request->status;

                    if ($request->status == "Rejected" || $request->status == "Cancelled") {
                        $checkUser->increment('credits_amount', $withdrawal->amount);
                    }

                    // Delete Data if the status is "Delete"
                    if ($request->status == "Delete") {
                        $withdrawal->delete();
                        return response([
                            'status' => 'success',
                            'message' => 'Withdrawal data has been deleted.',
                        ]);
                    }

                    // Save the withdrawal with the updated status
                    $withdrawal->save();

                    return response([
                        'status' => 'success',
                        'message' => 'You have updated the status to ' . $request->status,
                    ]);
                } else {
                    return response([
                        'status' => 'error',
                        'message' => 'Invalid withdrawal status request',
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Withdrawal status is not provided',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
