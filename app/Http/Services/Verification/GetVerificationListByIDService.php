<?php

namespace App\Http\Services\Verification;

use Throwable;
use Illuminate\Http\Request;
use App\Models\Verification;

class GetVerificationListByIDService
{
    public static function GetVerificationListByID(Request $request)
    {
        try {
            $verification = Verification::where('id', $request->id)
                ->with('user')
                ->orderBy("created_at", "desc")
                ->first();

            if (!$verification) {
                return response([
                    'status' => 'error',
                    'message' => 'Verification not found',
                ]);
            }

            $data[] = [
                'id' => $verification->id,
                'legal_name' => $verification->legal_name,
                'email' => $verification->user->email,
                'address' => $verification->address,
                'city' => $verification->city,
                'zip_code' => $verification->zip_code,
                'dob' => $verification->dob,
                'document_id' => $verification->img_file_path,
                'date_of_request' => date('Y-m-d H:i:s', strtotime($verification->created_at)),
            ];

            return response([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
