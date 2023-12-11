<?php

namespace App\Http\Services\Withdrawal;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;
use App\Models\User;

class RequestWithdrawalService
{
    public static function RequestWithdrawal(Request $request)
    {
        try {
            $user = Auth::user();
            $withdrawal = new Withdrawal();

            // Check Credits if able to withdraw
            $checkCredits = User::find($user->id);
            if ($checkCredits && ($checkCredits->credits_amount !== null && $checkCredits->credits_amount !== 0)) {
                if ($checkCredits->credits_amount >=! $request->amount) {
                    // Sufficient credits to proceed with the transaction
                    $checkCredits->update([
                        'credits_amount' => $checkCredits->credits_amount - $request->amount,
                    ]);
                }
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Buy wallet credits first!',
                ]);
            }

            if (!empty($request->transfer_to) && !empty($request->account_name) && !empty($request->account_number) && !empty($request->amount)) {
                if (filter_var($request->amount, FILTER_VALIDATE_INT) === false && filter_var($request->account_number, FILTER_VALIDATE_INT) === false) {
                    return response([
                        'status' => 'error',
                        'message' => "Invalid input number.",
                    ]);
                }

                if ($request->amount < 100 || $request->amount > 5000) {
                    return response([
                        'status' => 'error',
                        'message' => "Minimum withdrawal: P100.00, Maximum: P5000.00",
                    ]);
                } else {
                    $withdrawal->create([
                        'user_id' => $user->id,
                        'transfer_to' => $request->transfer_to,
                        'account_name' => $request->account_name,
                        'account_number' => $request->account_number,
                        'amount' => $request->amount,
                        'status' => 'Pending',
                    ]);
    
                    return response([
                        'status' => 'success',
                        'message' => 'Requested a withdrawal',
                    ]);
                }          
            } else {
                return response([
                    'status' => 'error',
                    'message' => "Please fill out this field.",
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
