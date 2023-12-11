<?php

namespace App\Http\Services\Settings;

use Throwable;
use Illuminate\Support\Facades\Auth;
use App\Models\Verification;

class GetVerificationStatusService
{
    public static function GetVerificationStatus()
    {
        try {

            $verification = Verification::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->first();
        
        return response([
            'status' => 'success',
            'data' => $verification ? $verification->status : null,
        ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
