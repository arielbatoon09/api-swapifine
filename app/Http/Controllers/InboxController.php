<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Inbox\GetAllContactsService;
use App\Http\Services\Inbox\ComposeMessageService;
use App\Http\Services\Inbox\TapToInquireService;
use App\Http\Services\Inbox\UpdateIsReadStatusService;
use App\Http\Services\Inbox\GetMessagesByIDService;

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
    public function ComposeMessage(Request $request)
    {
        return ComposeMessageService::ComposeMessage($request);
    }
    public function UpdateIsReadStatus(Request $request)
    {
        return UpdateIsReadStatusService::UpdateIsReadStatus($request);
    }
    public function GetMessagesByID(Request $request)
    {
        return GetMessagesByIDService::GetMessagesByID($request);
    }
}
