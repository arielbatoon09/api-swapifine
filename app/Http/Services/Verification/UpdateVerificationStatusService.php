<?php

namespace App\Http\Services\Verification;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Verification;

class UpdateVerificationStatusService
{
    public static function UpdateVerificationStatus(Request $request)
    {
        try {
            $verification = Verification::where('id', $request->id)->first();

            if (!empty($request->status)) {
                $status = in_array($request->status, ["Cancelled", "Rejected", "Approved"]) ? $request->status : null;
            
                $verification->status = $status;
                $verification->save();
            
                return response([
                    'status' => 'success',
                    'message' => 'You have updated the status to '.$status,
                ]);
            } else {
                return response([
                    'status' => 'error',
                    'message' => 'Not found status request',
                ]);
            }
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
