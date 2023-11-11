<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Verification\GetEveryVerificationListService;
use App\Http\Services\Verification\PostVerificationRequestService;

class VerificationController extends Controller
{
    public function GetEveryVerificationList()
    {
        return GetEveryVerificationListService::GetEveryVerificationList();
    }
    public function PostVerificationRequest(Request $request)
    {
        return PostVerificationRequestService::PostVerificationRequest($request);
    }
}