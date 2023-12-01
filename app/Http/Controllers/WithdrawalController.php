<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Withdrawal\GetEveryWithdrawalListService;
use App\Http\Services\Withdrawal\GetWithdrawalByIDService;
use App\Http\Services\Withdrawal\UpdateWithdrawalStatusService;

class WithdrawalController extends Controller
{
    public function GetEveryWithdrawalList()
    {
        return GetEveryWithdrawalListService::GetEveryWithdrawalList();
    }
    public function GetWithdrawalByID(Request $request)
    {
        return GetWithdrawalByIDService::GetWithdrawalByID($request);
    }
    public function UpdateWithdrawalStatus(Request $request)
    {
        return UpdateWithdrawalStatusService::UpdateWithdrawalStatus($request);
    }
}
