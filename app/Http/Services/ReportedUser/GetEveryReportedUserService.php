<?php

namespace App\Http\Services\ReportedUser;

use Throwable;
use App\Models\ReportedUser;

class GetEveryReportedUserService
{
    public static function GetEveryReportedUser()
    {
        try {
            $reportedUsers = ReportedUser::with('user')->orderBy("created_at", "desc")->get();

            $reportedUserData = [];

            foreach ($reportedUsers as $reportedUser) {
                $reportedUserData[] = [
                    'id' => $reportedUser->id,
                    'user_id' => $reportedUser->user_id,
                    'fullname' => $reportedUser->user->fullname,
                    'email' => $reportedUser->user->email,
                    'reported_by' => $reportedUser->reported_by,
                    'proof_img_path' => $reportedUser->proof_img_path,
                    'date_reported' => date('Y-m-d H:i:s', strtotime($reportedUser->created_at)),
                ];
            }

            return response([
                'status' => 'success',
                'data' => $reportedUserData,
            ]);
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}
