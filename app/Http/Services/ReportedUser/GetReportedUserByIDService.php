<?php

namespace App\Http\Services\ReportedUser;

use Throwable;
use Illuminate\Http\Request;
use App\Models\ReportedUser;

class GetReportedUserByIDService
{
    public static function GetReportedUserByID(Request $request)
    {
        try {
            $reportedUser = ReportedUser::where('id', $request->id)
            ->with('user')
            ->orderBy("created_at", "desc")
            ->first();

            if (!$reportedUser) {
                return response([
                    'status' => 'error',
                    'message' => 'Reported User not found',
                ]);
            }

            $data[] = [
                'id' => $reportedUser->id,
                'fullname' => $reportedUser->user->fullname,
                'reported_by' => $reportedUser->message,
                'proof_img_path' => $reportedUser->proof_img_path,
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