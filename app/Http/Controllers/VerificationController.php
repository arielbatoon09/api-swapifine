<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Verification\GetEveryVerificationListService;
use App\Http\Services\Verification\PostVerificationRequestService;
use App\Http\Services\Verification\GetVerificationListByIDService;
use App\Http\Services\Verification\UpdateVerificationStatusService;
use App\Http\Services\Settings\GetVerificationStatusService;

class VerificationController extends Controller
{
    public function GetEveryVerificationList()
    {
        return GetEveryVerificationListService::GetEveryVerificationList();
    }
    public function GetVerificationListByID(Request $request)
    {
        return GetVerificationListByIDService::GetVerificationListByID($request);
    }
    public function UpdateVerificationStatus(Request $request)
    {
        return UpdateVerificationStatusService::UpdateVerificationStatus($request);
    }
    public function PostVerificationRequest(Request $request)
    {
        return PostVerificationRequestService::PostVerificationRequest($request);
    }
    public function GetVerificationStatus()
    {
        return GetVerificationStatusService::GetVerificationStatus();
    }
}