<?php

namespace App\Http\Services\Verification;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Verification;

class GetEveryVerificationListService
{
    public static function GetEveryVerificationList()
    {
        try {
            $verifications = Verification::with('user')->orderBy("created_at", "desc")->get();
            $verificationData = [];
            
            foreach ($verifications as $verification) {
                $verificationData[] = [
                    'id' => $verification->id,
                    'user_id' => $verification->user_id,
                    'legal_name' => $verification->legal_name,
                    'email' => $verification->user->email,
                    'status' => $verification->status,
                    'date_of_request' => date('Y-m-d H:i:s', strtotime($verification->created_at)),
                ];
            }            

            return response([
                'status' => 'success',
                'data' => $verificationData,
            ]);

        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}