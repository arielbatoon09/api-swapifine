<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Withdrawal\GetEveryWithdrawalListService;

class WithdrawalController extends Controller
{
    public function GetEveryWithdrawalList()
    {
        return GetEveryWithdrawalListService::GetEveryWithdrawalList();
    }
}
