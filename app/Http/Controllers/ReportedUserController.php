<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ReportedUser\GetEveryReportedUserService;
use App\Http\Services\ReportedUser\PostReportUserService;

class ReportedUserController extends Controller
{
    public function GetEveryReportedUser()
    {
        return GetEveryReportedUserService::GetEveryReportedUser();
    }
    public function PostReportUser(Request $request)
    {
        return PostReportUserService::PostReportUser($request);
    }
}
