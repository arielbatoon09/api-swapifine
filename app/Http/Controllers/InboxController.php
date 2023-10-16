<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Inbox\GetAllContactsService;
use App\Http\Services\Inbox\TapToInquireService;
use App\Http\Services\Inbox\UpdateIsReadStatusService;

class InboxController extends Controller
{
    public function GetAllContacts()
    {
        return GetAllContactsService::GetAllContacts();
    }
    public function TapToInquire(Request $request)
    {
        return TapToInquireService::TapToInquire($request);
    }
    public function UpdateIsReadStatus(Request $request)
    {
        return UpdateIsReadStatusService::UpdateIsReadStatus($request);
    }
}
