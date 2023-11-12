<?php

namespace App\Http\Services\ReportedUser;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\ReportedUser;

class PostReportUserService
{
    public static function PostReportUser(Request $request)
    {
        try {
            
            $reportedUser = new ReportedUser();

            $reportedUser->create([
                'user_id' => $request->user_id,
                'reported_by' => Auth::user()->fullname,
                'message' => $request->message,
                'proof_img_path' => $request->proof_img_path,
            ]);

            return response([
                'status' => 'success',
                'message' => "Reported user successfully!",
            ]);
        
        } catch (Throwable $e) {
            return 'Error Catch: ' . $e->getMessage();
        }
    }
}