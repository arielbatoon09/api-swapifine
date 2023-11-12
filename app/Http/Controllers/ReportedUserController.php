<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ReportedUser\GetEveryReportedUserService;
use App\Http\Services\ReportedUser\PostReportUserService;
use App\Http\Services\ReportedUser\GetReportedUserByIDService;

class ReportedUserController extends Controller
{
    public function GetEveryReportedUser()
    {
        return GetEveryReportedUserService::GetEveryReportedUser();
    }
    public function GetReportedUserByID(Request $request)
    {
        return GetReportedUserByIDService::GetReportedUserByID($request);
    }
    public function PostReportUser(Request $request)
    {
        return PostReportUserService::PostReportUser($request);
    }
}
